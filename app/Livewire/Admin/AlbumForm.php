<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\{Album, AlbumCategory, Tag, AlbumImage};
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class AlbumForm extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $showModal = false, $isEditing = false, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'Album ';
    public $search = '';
    public $albumId;
    public $title, $description, $cover_image, $existingCover;
    public $category_id;
    public $tags = [];
    public $new_images = [];
    public $categories, $tagsList;
    public $filter_category, $filter_tag;

    public $viewModal = false, $albumImages = [];

    public function mount()
    {
        $this->categories = AlbumCategory::pluck('name', 'id');
        $this->tagsList = Tag::pluck('name', 'id');
    }
    public function render()
    {
        $albums = Album::with('category')->where('title', 'like', "%{$this->search}%");

        if (isset($this->filter_category) && !empty($this->filter_category)) {
            $albums->where('category_id', $this->filter_category);
        }
        if (!empty($this->filter_tag)) {
            $albums->whereHas('tags', function ($query) {
                $query->where('tags.id', $this->filter_tag);
            });
        }

        $albums = $albums->latest()->paginate(10);
        return view('livewire.admin.album-form', compact('albums'));
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_category','filter_tag']);
    }
    public function resetFields()
    {
        $this->reset([
            'title',
            'description',
            'category_id',
            'cover_image',
            'new_images',
            'albumId',
            'isEditing',
            'modalTitle',
            'existingCover',
            'tags'
        ]);
    }

    public function openModal()
    {
        $this->resetFields();
        $this->resetValidation();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function submit()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:album_categories,id',
            'cover_image' => 'nullable|image|max:2048',
            'new_images.*' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];

        if ($this->cover_image) {
            $data['cover_image'] = $this->cover_image->store('albums/covers', 'public_root');
        } elseif ($this->existingCover) {
            $data['cover_image'] = $this->existingCover;
        }

        $album = Album::updateOrCreate(['id' => $this->albumId], $data);

        $album->tags()->sync($this->tags);

        foreach ($this->new_images as $img) {
            AlbumImage::create([
                'album_id' => $album->id,
                'image_path' => $img->store('albums/gallery', 'public_root'),
            ]);
        }

        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        $this->showModal = false;

    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();

        $album = Album::with('tags', 'images')->findOrFail($id);
        $this->title = $album->title;
        $this->description = $album->description;
        $this->category_id = $album->category_id;
        $this->existingCover = $album->cover_image;
        $this->tags = $album->tags->pluck('id')->toArray();

        $this->albumId = $album->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:album_categories,id',
            'cover_image' => 'nullable|image|max:2048',
            'new_images.*' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];

        if ($this->cover_image) {
            $data['cover_image'] = $this->cover_image->store('albums/covers', 'public_root');
        } elseif ($this->existingCover) {
            $data['cover_image'] = $this->existingCover;
        }

        $album = Album::updateOrCreate(['id' => $this->albumId], $data);

        $album->tags()->sync($this->tags);

        foreach ($this->new_images as $img) {
            AlbumImage::create([
                'album_id' => $album->id,
                'image_path' => $img->store('albums/gallery', 'public_root'),
            ]);
        }

        $this->resetFields();
        $this->showModal = false;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        Album::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }

    public function viewImages($id)
    {
        $this->reset('albumImages');
        $this->albumImages = AlbumImage::where('album_id', $id)->pluck('image_path');
        // dd($this->albumImages);
        $this->modalTitle = 'View ' . $this->pageTitle . ' Images';
        $this->viewModal = true;
    }
}
