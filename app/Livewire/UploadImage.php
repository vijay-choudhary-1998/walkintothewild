<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Upload;
use Livewire\Attributes\Modelable;

class UploadImage extends Component
{
    use WithFileUploads;

    // #[Modelable]
    public $imageIds = [];

    public $photos = []; // multiple file uploads
    public $previews = [];

    public function updatedPhotos()
    {
        $this->previews = [];

        foreach ($this->photos as $photo) {
            $this->previews[] = $photo->temporaryUrl();
        }
    }

    public function upload()
    {
        $this->validate([
            'photos.*' => 'required|image|max:2048'
        ]);

        foreach ($this->photos as $photo) {
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('uploads', $filename, ['disk' => 'public_root']);
            $path = 'uploads/' . $filename;

            $upload = Upload::create([
                'path' => $path
            ]);

            $this->imageIds[] = $upload->id;

            $this->dispatch('imageUploaded', id: $upload->id, path: $path);
        }

        $this->photos = [];
        $this->previews = [];
    }

    public function render()
    {
        return view('livewire.upload-image');
    }
}
