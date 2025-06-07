<?php

namespace App\Livewire\Admin;


use App\Models\Wildlife;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class WildlifeCrud extends Component
{
    use WithPagination;

    public $name, $species, $habitat, $description, $wildlife_id;
    public $isEditing = false;
    public $showModal = false;
    public $modalTitle = 'Add', $pageTitle = 'Wildlife';

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    protected $rules = [
        'name' => 'required|string|min:3',
        'species' => 'required|string',
        'habitat' => 'nullable|string',
        'description' => 'nullable|string'
    ];

    public function render()
    {
        $wildlifes = Wildlife::where('name', 'like', "%{$this->search}%")
            ->latest()->paginate(10);
        return view('livewire.admin.wildlife-crud', compact('wildlifes'));
    }

    public function resetFilter()
    {
        $this->reset(['search']);
    }


    public function resetFields()
    {
        $this->reset(['name', 'species', 'habitat', 'description', 'wildlife_id', 'isEditing', 'modalTitle']);
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
        Wildlife::create($this->only((new Wildlife)->getFillable()));
        $this->showModal = false;
        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }

    public function edit($id)
    {
        $wildlife = Wildlife::findOrFail($id);
        foreach ($wildlife->getFillable() as $field) {
            $this->$field = $wildlife->$field;
        }
        $this->wildlife_id = $wildlife->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();
        $wildlife = Wildlife::findOrFail($this->wildlife_id);
        $wildlife->update($this->only($wildlife->getFillable()));
        $this->showModal = false;
        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
    }

    public function delete($id)
    {
        Wildlife::destroy($id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }

    public function updating()
    {
        $this->resetPage();
    }
}