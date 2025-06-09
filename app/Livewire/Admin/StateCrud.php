<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\State;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class StateCrud extends Component
{
    use WithPagination;

    public $state_name, $country;
    public $countries;
    public $stateId;

    public $showModal = false, $isEditing = false, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'State';
    public $search = '';
    public $filter_country,$filter_country_temp;

    public function resetFields()
    {
        $this->reset([
            'state_name',
            'country',
            'stateId',
            'isEditing',
            'modalTitle'
        ]);
    }
    public function mount()
    {
        $this->countries = Country::pluck('name', 'id');
    }
    public function render()
    {
        $states = State::where('name', 'like', "%{$this->search}%");
        if (isset($this->filter_country_temp) && !empty($this->filter_country_temp)) {
            $states->where('country_id', $this->filter_country_temp);
        }
        $states = $states->latest()->paginate(10);
        return view('livewire.admin.state-crud', compact('states'));
    }
    public function applyFilter()
    {
        $this->filter_country_temp = $this->filter_country;
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_country','filter_country_temp']);
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
            'state_name' => 'required|unique:states,name',
            'country' => 'required|exists:countries,id',
        ]);

        State::create([
            'name' => $this->state_name,
            'country_id' => $this->country,
        ]);

        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        $this->showModal = false;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $state = State::findOrFail($id);
        $this->state_name = $state->name;
        $this->country = $state->country_id;

        $this->stateId = $state->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $state = State::findOrFail($this->stateId);
        $state->update([
            'name' => $this->state_name,
            'country_id' => $this->country,
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
        State::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }
}
