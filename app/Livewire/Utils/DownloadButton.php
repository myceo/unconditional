<?php

namespace App\Livewire\Utils;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DownloadButton extends Component
{

    public $fileName;
    public $filePath;
    public $btnSize='btn-sm';
    public function render()
    {
        return view('livewire.utils.download-button');
    }

    public function download(){
        return  Storage::disk(PUBLIC_UPLOADS)->download($this->filePath,$this->fileName);
    }

}
