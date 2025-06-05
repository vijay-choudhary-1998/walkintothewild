<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Park;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin-app')]
class ParkCrud extends Component
{
    use WithPagination;

    public $modalTitle = 'Add', $pageTitle = 'Park';

    public $title, $slug, $short_description, $description,
    $city, $state, $country, $train, $airport, $safari_session,
    $wildlife_found, $safari_cost, $safari_mode, $closed_months, $park_id;
    public $showModal = false, $isEditing = false, $deleteId;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    protected $rules = [
        'title' => 'required',
        'slug' => 'required|unique:parks,slug'
    ];

    public function render()
    {
        $parks = Park::where('title', 'like', "%{$this->search}%")
            ->latest()->paginate(10);
        return view('livewire.admin.park-crud', compact('parks'));
    }

    public function resetFields()
    {
        $this->reset([
            'title',
            'slug',
            'short_description',
            'description',
            'city',
            'state',
            'country',
            'train',
            'airport',
            'safari_session',
            'wildlife_found',
            'safari_cost',
            'safari_mode',
            'closed_months',
            'park_id',
            'isEditing',
            'modalTitle'
        ]);
    }

    public function openModal()
    {
        $this->resetFields();
        $this->resetValidation();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();
        Park::create($this->only((new Park)->getFillable()));
        $this->showModal = false;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        $this->resetFields();
    }

    public function edit($id)
    {
        $park = Park::findOrFail($id);
        foreach ($park->getFillable() as $field) {
            $this->$field = $park->$field;
        }
        $this->park_id = $park->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'slug' => 'required|unique:parks,slug,' . $this->park_id
        ]);
        $park = Park::findOrFail($this->park_id);
        $park->update($this->only($park->getFillable()));
        $this->showModal = false;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
        $this->resetFields();
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
        Park::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }
}