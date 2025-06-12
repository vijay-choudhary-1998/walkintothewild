<?php

namespace App\Livewire\Components;

use App\Helpers\ImageHelper;
use App\Models\Upload;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImageUploader extends Component
{

    use WithFileUploads;

    public array $images = [];
    public bool $multiple = false;


    public function updatedImages()
    {
        if (!$this->multiple && count($this->images) > 1) {
            $this->images = [$this->images[0]];
        }
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    public function uploadImages()
    {
        $this->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $uploadedIds = [];

        foreach ($this->images as $image) {
            $path = 'uploads/images/test';
            $origPath = $image->store($path, 'public_root');

            $avifPath = ImageHelper::convertToAvif($origPath,$path);

            $upload = Upload::create([
                'original_name' => $image->getClientOriginalName(),
                'avif_path' => $avifPath,
            ]);

            $uploadedIds[] = $upload->id;
        }

        $this->dispatch('imagesUploaded', ids: $uploadedIds);
        session()->flash('success', 'Image(s) uploaded and converted to AVIF.');
        $this->reset('images');
    }

    public function render()
    {
        return view('livewire.components.image-uploader');
    }
}

