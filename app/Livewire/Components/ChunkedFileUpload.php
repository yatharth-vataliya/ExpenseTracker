<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChunkedFileUpload extends Component
{
    use WithFileUploads;

    public $fileName;

    public $fileSize;

    public $chunkSize = 1024 * 1024 * 5;

    public $fileChunk;

    public function updatedFileChunk()
    {
        Storage::putFile('/public/'.$this->fileName, $this->fileChunk);
        $this->js("console.log('something')");
    }

    public function render()
    {
        return view('livewire.components.chunked-file-upload');
    }
}
