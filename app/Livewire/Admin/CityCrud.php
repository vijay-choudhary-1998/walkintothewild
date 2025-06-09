<?php

namespace App\Livewire\Admin;

use App\Models\City;
use App\Models\State;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class CityCrud extends Component
{
    use WithPagination;
    public $city_name, $state;
    public $states;
    public $cityId;

    public $showModal = false, $isEditing = false, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'City';
    public $search = '';
    public $filter_state,$filter_state_temp;

    public function resetFields()
    {
        $this->reset([
            'city_name',
            'state',
            'cityId',
            'isEditing',
            'modalTitle'
        ]);
    }
    public function mount()
    {
        $this->states = State::pluck('name', 'id');
    }
    public function render()
    {
        $cities = City::where('name', 'like', "%{$this->search}%");

        if (isset($this->filter_state) && !empty($this->filter_state)) {
            $cities->where('state_id', $this->filter_state);
        }

        $cities = $cities->latest()->paginate(10);

        return view('livewire.admin.city-crud', compact('cities'));
    }
    public function applyFilter()
    {
        $this->filter_state_temp = $this->filter_state;
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_state','filter_state_temp']);
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
            'city_name' => 'required|unique:cities,name',
            'state' => 'required|exists:states,id',
        ]);

        City::create([
            'name' => $this->city_name,
            'state_id' => $this->state,
        ]);

        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        $this->showModal = false;

    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $city = City::findOrFail($id);
        $this->city_name = $city->name;
        $this->state = $city->state_id;

        $this->cityId = $city->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $city = City::findOrFail($this->cityId);
        $city->update([
            'name' => $this->city_name,
            'state_id' => $this->state,
        ]);
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
        City::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }
}
