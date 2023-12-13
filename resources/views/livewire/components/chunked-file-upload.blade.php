<div class="p-4 w-full">
    <div x-data="upload" class="w-full">
        <form wire:submit="submit" enctype="multipart/form-data">
            <input class="hidden" id="upload" name="upload" x-ref="upload" type="file" x-on:change="uploadChange" />
            <button class="p-2 hover:shadow-lg bg-white text-black rounded" type="button"
                x-on:click="$refs.upload.click()">
                Select Files
            </button>
            <button class="p-2 hover:shadow-lg bg-black text-white rounded"
                :class="isButtonDisabled ? 'bg-gray-500 hover:shadow-none cursor-not-allowed' : ''" type="button"
                x-on:click="uploadChunks" :disabled="isButtonDisabled">
                Submit
            </button>
        </form>
        <div class="my-2 w-full" x-show="progressValue > 0">
            <progress class="w-full" x-bind:max="maxProgressValue" x-bind:value="progressValue" id="fileUploadProgress"
                x-text="progressValue"></progress>
        </div>
    </div>
    @script
        <script>
            Alpine.data('upload', () => {
                return {
                    fileName: '',
                    isFirstCall: true,
                    isButtonDisabled: true,
                    maxProgressValue: 0,
                    progressValue: 0,
                    chunkSize: 1024 * 1024 * 5,
                    uploadChange(el) {
                        this.isButtonDisabled = el.target.files.length > 0 ? false : true;
                    },
                    uploadChunks() {
                        this.isButtonDisabled = true;
                        const file = document.querySelector('#upload').files[0];
                        this.maxProgressValue = file.size > this.chunkSize ? file.size / this.chunkSize : 100;
                        //$wire.set('fileName', file.name, true);
                        //$wire.set('fileSize', file.size, true);
                        this.livewireUploadChunk(file, 0);
                    },
                    async livewireUploadChunk(file, start) {
                        this.fileName = file.name;
                        /*const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('fileName', this.fileName);
                        formData.append('isFirstCall', this.isFirstCall);
                        if (file.size < this.chunkSize) {
                            formData.set('fileData', file);
                            await fetch('{{ route('upload-data') }}', {
                                method: 'POST',
                                body: formData,
                            }).then(async (response) => {
                                delete formData;
                            });
                            this.isFirstCall = true;
                        }
                        if (file.size > this.chunkSize) {
                            for (let i = 0; i < file.size; i = i + this.chunkSize) {
                                let chunk;
                                if (i !== 0) {
                                    formData.set('isFirstCall', false);
                                    this.isFirstCall = false;
                                }
                                chunk = file.slice(i, (i + this.chunkSize));
                                formData.set('fileData', chunk);
                                await fetch('{{ route('upload-data') }}', {
                                    method: 'POST',
                                    body: formData,
                                }).then(async (response) => {
                                    console.log('this is line number 82 without in condition');
                                    console.log(await response.text());
                                });
                            }
                        }
                        //const response = await Promise.allSettled(uploadChunksArray); // this is not working because it doesn't respect the order of request

                        this.isFirstCall = true;
                        this.isButtonDisabled = false;
                        this.$refs.upload.value = '';
                        this.$refs.upload.dispatchEvent(new Event('change'));
                        */

                        const chunkEnd = Math.min(start + this.chunkSize, file.size);
                        const chunk = file.slice(start, chunkEnd);
                        const formData = new FormData();
                        formData.append('fileData', chunk);
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('fileName', this.fileName);
                        formData.append('isFirstCall', this.isFirstCall);
                        await fetch('{{ route('upload-data') }}', {
                            method: 'POST',
                            body: formData,
                        }).then(async (response) => {
                            delete formData;
                            this.isFirstCall = false;
                            this.progressValue = ++this.progressValue;
                            start = chunkEnd;
                            if (start < file.size) {
                                await this.livewireUploadChunk(file, start);
                            }
                        });
                        this.progressValue = this.maxProgressValue;
                        this.progressValue = 0;
                        this.isFirstCall = true;
                        this.isButtonDisabled = false;
                        this.$refs.upload.value = '';
                        this.$refs.upload.dispatchEvent(new Event('change'));
                    },
                };
            });
        </script>
    @endscript
</div>
