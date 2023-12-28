<div class="p-4 w-full">
    <div x-data="upload" class="w-full">
        <form wire:submit="submit" enctype="multipart/form-data">
            <input class="hidden" id="upload" name="upload" x-ref="upload" type="file" x-on:change="uploadChange"
                multiple />
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
        <template x-for="(file, index) in files" x-bind:key="index">
            <div class="border rounded shadow border-violet-100 my-2">
                <div class="p-2">
                    <p>File Name :- <span x-text="file.name"></span></p>
                </div>
                <div class="p-2" x-show="progressValueInPercentage[index]">
                    <span x-text="`Total progress in percentage :- ${progressValueInPercentage[index]} %`"></span>
                </div>
                <div class="p-2" x-show="chunkUploadProgressValue[index]">
                    <progress class="w-full" max="100" x-bind:value="chunkUploadProgressValue[index]"
                        x-bind:id="`fileUploadChunkProgress_${index}`"></progress>
                </div>
                <div class="p-2 w-full" x-show="progressValue[index]">
                    <progress class="w-full" x-bind:max="maxProgressValue[index]" x-bind:value="progressValue[index]"
                        x-bind:id="`fileUploadProgress_${index}`"></progress>
                </div>
            </div>
        </template>
    </div>
    @script
        <script>
            Alpine.data('upload', () => {
                return {
                    fileName: '',
                    files: [],
                    isFirstCall: [],
                    isButtonDisabled: true,
                    maxProgressValue: [],
                    progressValue: [],
                    chunkSize: 1024 * 1024 * 5,
                    progressValueInPercentage: [],
                    chunkUploadProgressValue: [],
                    uploadChange(el) {
                        this.isButtonDisabled = el.target.files.length > 0 ? false : true;
                        this.files = [...document.querySelector('#upload').files];
                        this.files.forEach((file, index) => {
                            this.isFirstCall[index] = true;
                            this.progressValue[index] = 0;
                            this.progressValueInPercentage[index] = 0;
                            this.maxProgressValue[index] = 100;
                            this.chunkUploadProgressValue[index] = 0;
                        });
                    },
                    async uploadChunks() {
                        this.isButtonDisabled = true;
                        console.log(this.files.length);
                        for (let i = 0; i < this.files.length; i++) {
                            const index = i;
                            const tempFile = this.files[index];
                            const tempFileName = this.files[index].name;
                            const tempFileSize = this.files[index].size;
                            this.maxProgressValue[index] = Math.round(tempFileSize > this.chunkSize ? tempFileSize /
                                this.chunkSize : 100);
                            @this.set('fileName', tempFileName);
                            @this.set('isFirstCall', true);
                            this.fileName = tempFileName;
                            await this.livewireUploadChunk(tempFile, 0, index);
                            if (index == (1 - this.files.length)) {
                                this.isButtonDisabled = false;
                                this.$refs.upload.value = '';
                                this.$refs.upload.dispatchEvent(new Event('change'));
                            }
                        }
                        /*await this.files.forEach(async (file, index) => {
                            this.maxProgressValue[index] = Math.round(file.size > this.chunkSize ? file
                                .size / this
                                .chunkSize :
                                100);
                            @this.set('fileName', file.name);
                            @this.set('isFirstCall', true);
                            this.fileName = file.name;
                            await this.livewireUploadChunk(file, 0, index);
                            if (index == this.files.length) {
                                this.isButtonDisabled = false;
                                this.$refs.upload.value = '';
                                this.$refs.upload.dispatchEvent(new Event('change'));
                            }
                        });*/
                        //this.isButtonDisabled = false;
                        //this.$refs.upload.value = '';
                        //this.$refs.upload.dispatchEvent(new Event('change'));
                    },
                    async livewireUploadChunk(file, start, index) {

                        //This method to submit files is using Livewire techniques.
                        const chunkEnd = Math.min(start + this.chunkSize, file.size);
                        const chunk = file.slice(start, chunkEnd);
                        await @this.upload('fileChunk', chunk,
                            async (uploadedFileName) => {
                                    console.info('This is file name that uploaded recenctly ',
                                        uploadedFileName);
                                    delete chunk;
                                    @this.set('isFirstCall', false);
                                    this.progressValue[index] = ++this.progressValue[index];
                                    if (this.progressValue[index] > 0 && file.size > this.chunkSize) {
                                        this.progressValueInPercentage[index] = Math.round((this
                                                .progressValue[
                                                    index] * 100) /
                                            totalChunks);
                                    } else {
                                        this.progressValueInPercentage[index] = 100;
                                    }
                                },
                                () => {
                                    console.error('This is error while uploading file');
                                },
                                async (event) => {
                                    this.chunkUploadProgressValue[index] = event.detail.progress;
                                    if (event.detail.progress == 100) {
                                        if (chunkEnd < file.size) {
                                            await this.livewireUploadChunk(file, chunkEnd, index);
                                        }
                                    }
                                    delete chunkEnd;
                                }
                        );

                        // This method to submit files is using fetch API and for loop.
                        /*const formData = new FormData();
                        formData.set('_token', '{{ csrf_token() }}');
                        formData.set('fileName', this.fileName);
                        formData.set('isFirstCall', this.isFirstCall);
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

                        // This method to submit files is using fetch API and recursion of function.
                        /*const chunkEnd = Math.min(start + this.chunkSize, file.size);
                        const chunk = file.slice(start, chunkEnd);
                        const formData = new FormData();
                        const totalChunks = file.size > this.chunkSize ? Math.ceil(file.size / this.chunkSize) : 1;
                        formData.set('fileData', chunk);
                        formData.set('_token', '{{ csrf_token() }}');
                        formData.set('fileName', file.name);
                        formData.set('isFirstCall', this.isFirstCall[index]);
                        await fetch('{{ route('upload-data') }}', {
                            method: 'POST',
                            body: formData,
                        }).then(async (response) => {
                            delete formData;
                            this.isFirstCall[index] = false;
                            this.progressValue[index] = ++this.progressValue[index];
                            if (this.progressValue[index] > 0 && file.size > this.chunkSize) {
                                this.progressValueInPercentage[index] = Math.round((this.progressValue[
                                        index] * 100) /
                                    totalChunks);
                            } else {
                                this.progressValueInPercentage[index] = 100;
                            }
                            start = chunkEnd;
                            if (start < file.size) {
                                await this.livewireUploadChunk(file, start, index);
                            }
                        });
                        this.progressValue[index] = this.maxProgressValue[index];
                        this.progressValue[index] = 0;
                        this.isFirstCall[index] = true;*/
                    },
                };
            });
        </script>
    @endscript
</div>
