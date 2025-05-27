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
    public $modalTitle = 'Add Wildlife';

    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'name' => 'required|string|min:3',
        'species' => 'required|string',
        'habitat' => 'nullable|string',
        'description' => 'nullable|string'
    ];

    public function render()
    {
        return view('livewire.admin.wildlife-crud', [
            'wildlifes' => Wildlife::latest()->paginate(10)
        ]);
    }

    public function resetFields()
    {
        $this->reset(['name', 'species', 'habitat', 'description', 'wildlife_id', 'isEditing', 'modalTitle']);
    }

    public function openModal()
    {
        $this->resetFields();
        $this->dispatch('show-form');
    }

    public function store()
    {
        $this->validate();
        Wildlife::create($this->only((new Wildlife)->getFillable()));
        $this->dispatch('hide-form');
        $this->resetFields();
    }

    public function edit($id)
    {
        $wildlife = Wildlife::findOrFail($id);
        foreach ($wildlife->getFillable() as $field) {
            $this->$field = $wildlife->$field;
        }
        $this->wildlife_id = $wildlife->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit Wildlife';
        $this->dispatch('show-form');
    }

    public function update()
    {
        $this->validate();
        $wildlife = Wildlife::findOrFail($this->wildlife_id);
        $wildlife->update($this->only($wildlife->getFillable()));
        $this->dispatch('hide-form');
        $this->resetFields();
    }

    public function delete($id)
    {
        Wildlife::destroy($id);
    }

    public function updating(){
        $this->resetPage();
    }
}