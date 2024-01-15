<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChunkedFileUpload extends Component
{
    use WithFileUploads;

    public $fileName;

    public $isFirstCall;

    public $fileSize;

    public $chunkSize = 1024 * 1024 * 5;

    public $fileChunk;

    public function updatedFileChunk()
    {
        $tmpHandle = fopen(Storage::path('/livewire-tmp/'.$this->fileChunk->getFileName()), 'rb');
        $tmpBuff = fread($tmpHandle, $this->chunkSize);

        $finalFilePath = Storage::path('/public/'.$this->fileName);
        if ($this->isFirstCall && Storage::exists('/public/'.$this->fileName)) {
            Storage::delete('/public/'.$this->fileName);
            sleep(1);
        }

        $fileHandle = fopen($finalFilePath, 'ab');
        fwrite($fileHandle, $tmpBuff);

        fclose($tmpHandle);
        fclose($fileHandle);
        Storage::delete('/livewire-tmp/'.$this->fileChunk->getFileName());
    }

    public function render()
    {
        return view('livewire.components.chunked-file-upload');
    }
}
