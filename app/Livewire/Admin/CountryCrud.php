<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class CountryCrud extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $country_name, $country_code, $phone_code;
    public $isEditing = false;
    public $countryId;
    public function render()
    {
        return view('livewire.admin.country-crud', [
            'countries' => Country::latest()->paginate(10)
        ]);
    }
    public function submit()
    {
        $this->validate([
            'country_name' => 'required',
            'country_code' => 'required|unique:countries,sortname|max:3',
            'phone_code' => 'required|numeric|max_digits:11',
        ]);

        Country::create([
            'sortname' => $this->country_code,
            'name' => $this->country_name,
            'phonecode' => $this->phone_code,
        ]);

        $this->reset('country_name', 'country_code', 'phone_code');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'New country added successfully.']);

    }

    public function delete($id)
    {
        Country::destroy($id);
        $this->reset('country_name', 'country_code', 'phone_code', 'countryId', 'isEditing');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Countrt deleted successfully.']);
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->reset('country_name', 'country_code', 'phone_code', 'countryId', 'isEditing');
        $country = Country::findOrFail($id);
        $this->country_name = $country->name;
        $this->country_code = $country->sortname;
        $this->phone_code = $country->phonecode;

        $this->countryId = $country->id;
        $this->isEditing = true;
        $this->resetValidation();
    }

    public function update()
    {
        $country = Country::findOrFail($this->countryId);
        $country->update([
            'sortname' => $this->country_code,
            'name' => $this->country_name,
            'phonecode' => $this->phone_code,
        ]);
        $this->reset('country_name', 'country_code', 'phone_code', 'countryId', 'isEditing');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Country detail has been updated successfully.']);
    }
}
