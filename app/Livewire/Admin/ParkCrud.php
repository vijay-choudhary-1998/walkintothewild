<?php

namespace App\Livewire\Admin;

use App\Models\City;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Park;
use App\Models\State;
use App\Models\Wildlife;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin-app')]
class ParkCrud extends Component
{
    use WithPagination;

    public $modalTitle = 'Add', $pageTitle = 'Park';

    public $title, $short_description, $description,
    $city_id, $state_id, $country_id, $train, $airport, $safari_session,
    $wildlife_found, $safari_cost, $safari_mode, $closed_months, $park_id;
    public $showModal = false, $isEditing = false, $deleteId;

    public $search = '';
    public $countries = [], $states = [], $cities = [], $wildlives;
    public $filter_country, $filter_state, $filter_city, $filter_wildlife;
    public $filter_countries = [], $filter_states = [], $filter_cities = [];
    public $filter_country_temp, $filter_wildlife_temp, $filter_state_temp, $filter_city_temp;

    protected $rules = [
        'title' => 'required',
        'short_description' => 'required',
        'description' => 'required',
        'city_id' => 'required',
        'state_id' => 'required',
        'country_id' => 'required',
        'train' => 'required',
        'airport' => 'required',
        'safari_session' => 'required',
        'wildlife_found' => 'required',
        'safari_cost' => 'required',
        'safari_mode' => 'required',
        'closed_months' => 'required',
    ];
    public function mount()
    {
        $this->filter_countries = $this->countries = Country::pluck('name', 'id');
        $this->wildlives = Wildlife::pluck('name', 'id');
    }
    public function render()
    {
        $parks = Park::where('title', 'like', "%{$this->search}%");
        if (isset($this->filter_country_temp) && !empty($this->filter_country_temp)) {
            $parks->where('country_id', $this->filter_country_temp);
        }
        if (isset($this->filter_wildlife_temp) && !empty($this->filter_wildlife_temp)) {
            $parks->where('wildlife_found', $this->filter_wildlife_temp);
        }
        if (isset($this->filter_state_temp) && !empty($this->filter_state_temp)) {
            $parks->where('state_id', $this->filter_state_temp);
        }
        if (isset($this->filter_city_temp) && !empty($this->filter_city_temp)) {
            $parks->where('city_id', $this->filter_city_temp);
        }
        $parks = $parks->latest()->paginate(10);
        return view('livewire.admin.park-crud', compact('parks'));
    }
    public function applyFilter()
    {
        $this->filter_country_temp = $this->filter_country;
        $this->filter_wildlife_temp = $this->filter_wildlife;
        $this->filter_state_temp = $this->filter_state;
        $this->filter_city_temp = $this->filter_city;

    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_country', 'filter_state', 'filter_city', 'filter_wildlife', 'filter_country_temp', 'filter_wildlife_temp', 'filter_state_temp', 'filter_city_temp']);
    }

    public function resetFields()
    {
        $this->reset([
            'title',
            'short_description',
            'description',
            'city_id',
            'state_id',
            'country_id',
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
        $this->closed_months = is_array($this->closed_months)
            ? implode(',', $this->closed_months)
            : $this->closed_months;
        Park::create($this->only((new Park)->getFillable()));
        $this->showModal = false;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        $this->resetFields();
    }

    public function edit($id)
    {
        $park = Park::findOrFail($id);
        foreach ($park->getFillable() as $field) {
            if ($field == 'closed_months') {
                $this->closed_months = explode(',', $park->closed_months);
            } else {
                $this->$field = $park->$field;
            }
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
        ]);
        $park = Park::findOrFail($this->park_id);

        $data = $this->only($park->getFillable());
        $data['closed_months'] = is_array($this->closed_months)
            ? implode(',', $this->closed_months)
            : $this->closed_months;

        unset($data['slug']);

        $park->fill($data);
        $park->save();

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

    public function updatedCountryId($value)
    {
        $this->states = State::where('country_id', $value)->pluck('name', 'id');
        $this->reset('state_id', 'cities', 'city_id');
    }
    public function updatedStateId($value)
    {
        $this->cities = City::where('state_id', $value)->pluck('name', 'id');
        $this->reset('city_id');
    }
    public function updatedFilterCountry($value)
    {
        $this->filter_states = State::where('country_id', $value)->pluck('name', 'id');
        $this->reset('filter_state', 'filter_cities', 'filter_city');
    }
    public function updatedFilterState($value)
    {
        $this->filter_cities = City::where('state_id', $value)->pluck('name', 'id');
        $this->reset('filter_city');
    }
}