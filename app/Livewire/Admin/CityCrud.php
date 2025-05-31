<?php

namespace App\Livewire\Admin;

use App\Models\City;
use App\Models\State;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class CityCrud extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $city_name, $state;
    public $isEditing = false;
    public $states;
    public $cityId;
    public function mount()
    {
        $this->states = State::pluck('name', 'id');
    }
    public function render()
    {
        return view('livewire.admin.city-crud', [
            'cities' => City::latest()->paginate(10)
        ]);
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

        $this->reset('city_name', 'state');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'New city added successfully.']);

    }

    public function delete($id)
    {
        City::destroy($id);
        $this->reset('city_name', 'state', 'cityId', 'isEditing');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'city deleted successfully.']);
    }
    public function updating()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->reset('city_name', 'state', 'cityId', 'isEditing');
        $city = City::findOrFail($id);
        $this->city_name = $city->name;
        $this->state = $city->state_id;

        $this->cityId = $city->id;
        $this->isEditing = true;
        $this->resetValidation();
    }

    public function update()
    {
        $city = City::findOrFail($this->cityId);
        $city->update([
            'name' => $this->city_name,
            'state_id' => $this->state,
        ]);
        $this->reset('city_name', 'state', 'cityId', 'isEditing');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'City detail has been updated successfully.']);
    }
}
