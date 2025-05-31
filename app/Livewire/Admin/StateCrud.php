<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\State;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class StateCrud extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $state_name, $country;
    public $isEditing = false;
    public $countries;
    public $stateId;
    public function mount()
    {
        $this->countries = Country::pluck('name', 'id');
    }
    public function render()
    {
        return view('livewire.admin.state-crud', [
            'states' => State::latest()->paginate(10)
        ]);
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

        $this->reset('state_name', 'country');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'New state added successfully.']);

    }

    public function delete($id)
    {
        State::destroy($id);
        $this->reset('state_name', 'country', 'stateId', 'isEditing');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'State deleted successfully.']);
    }
    public function updating()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->reset('state_name', 'country', 'stateId', 'isEditing');
        $state = State::findOrFail($id);
        $this->state_name = $state->name;
        $this->country = $state->country_id;

        $this->stateId = $state->id;
        $this->isEditing = true;
        $this->resetValidation();
    }

    public function update()
    {
        $state = State::findOrFail($this->stateId);
        $state->update([
            'name' => $this->state_name,
            'country_id' => $this->country,
        ]);
        $this->reset('state_name', 'country', 'stateId', 'isEditing');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'State detail has been updated successfully.']);
    }
}
