<x-app-layout>
    <x-slot name="title">
        File Upload
    </x-slot>
    <div class="p-4 w-full">
        <div x-data="upload" class="w-full">
            <form wire:submit="submit" enctype="multipart/form-data">
                <input class="hidden" id="upload" name="upload" x-ref="upload" type="file" x-on:change="uploadChange"
                    multiple />
                <x-custom-button type="button" x-on:click="$refs.upload.click()">
                    Select Files
                </x-custom-button>
                <x-custom-button type="button" x-on:click="uploadChunks" x-bind:disabled="isButtonDisabled">
                    Submit
                </x-custom-button>
                <x-custom-button type="reset" x-on:click="reset()">
                    Reset
                </x-custom-button>
            </form>
            <template x-for="(file, index) in files" x-bind:key="index">
                <div class="border rounded shadow border-violet-100 my-2">
                    <div class="p-2">
                        <p>File Name :- <span x-text="file.name"></span></p>
                    </div>
                    <div class="p-2" x-show="progressValueInPercentage[index]">
                        <span x-text="`Total progress in percentage :- ${progressValueInPercentage[index]} %`"></span>
                    </div>
                    <div class="p-2 w-full" x-show="progressValue[index]">
                        <progress class="w-full" x-bind:max="maxProgressValue[index]"
                            x-bind:value="progressValue[index]" x-bind:id="`fileUploadProgress_${index}`"></progress>
                    </div>
                </div>
            </template>
        </div>
    </div>
    @push('scripts')
        <script>
            if (typeof window.Alpine === 'undefined') {
                document.addEventListener('DOMContentLoaded', () => {
                    initAlpine();
                });
            } else {
                initAlpine();
            }

            function initAlpine() {
                Alpine.data('upload', () => {
                    return {
                        fileName: '',
                        files: [],
                        isButtonDisabled: true,
                        maxProgressValue: [],
                        progressValue: [],
                        chunkSize: 1024 * 1024 * 5,
                        progressValueInPercentage: [],
                        reset() {
                            this.files = [];
                            this.isButtonDisabled = true;
                            this.$refs.upload.value = '';
                            this.$refs.upload.dispatchEvent(new Event('change'));
                        },
                        uploadChange(el) {
                            this.isButtonDisabled = el.target.files.length > 0 ? false : true;
                            this.files = [...document.querySelector('#upload').files];
                            this.files.forEach((file, index) => {
                                this.progressValue[index] = 0;
                                this.progressValueInPercentage[index] = 0;
                                this.maxProgressValue[index] = 100;
                            });
                        },
                        async uploadChunks() {
                            this.isButtonDisabled = true;
                            for (let i = 0; i < this.files.length; i++) {
                                const index = i;
                                const tempFile = this.files[index];
                                const tempFileName = this.files[index].name;
                                const tempFileSize = this.files[index].size;
                                this.maxProgressValue[index] = Math.round(tempFileSize > this.chunkSize ?
                                    tempFileSize /
                                    this.chunkSize : 100);
                                this.fileName = tempFileName;
                                await this.uploadFileChunk(tempFile, 0, index);
                                if (index == (this.files.length - 1)) {
                                    this.isButtonDisabled = true;
                                    this.$refs.upload.value = '';
                                    this.$refs.upload.dispatchEvent(new Event('change'));
                                }
                            }
                        },
                        async uploadFileChunk(file, start, index) {

                            const formData = new FormData();
                            formData.set('_token', '{{ csrf_token() }}');
                            formData.set('fileName', file.name);
                            formData.set('isFirstCall', true);
                            const totalChunks = Math.ceil(file.size / this.chunkSize);
                            this.maxProgressValue[index] = totalChunks;
                            if (file.size < this.chunkSize) {
                                formData.set('fileData', file);
                                await fetch('{{ route('upload-data') }}', {
                                    method: 'POST',
                                    body: formData,
                                }).then(async (response) => {
                                    if (await response.ok) {
                                        this.progressValue[index] = 100;
                                        this.progressValueInPercentage[index] = 100;
                                    }
                                });
                            }
                            if (file.size > this.chunkSize) {
                                for (let i = 0; i < file.size; i = i + this.chunkSize) {
                                    let chunk;
                                    if (i !== 0) {
                                        formData.set('isFirstCall', false);
                                    }
                                    chunk = file.slice(i, (i + this.chunkSize));
                                    formData.set('fileData', chunk);
                                    await fetch('{{ route('upload-data') }}', {
                                        method: 'POST',
                                        body: formData,
                                    }).then(async (response) => {
                                        if (await response.ok) {
                                            this.progressValue[index] += 1;
                                            this.progressValueInPercentage[index] = Math.round((
                                                100 * this
                                                .progressValue[index]) / totalChunks);
                                        }
                                    });
                                    delete chunk;
                                }
                            }
                            delete formData;
                            delete totalChunks;
                        },
                    };
                });
            }
        </script>
    @endpush

</x-app-layout>
