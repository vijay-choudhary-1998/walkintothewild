<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use PhpParser\NodeVisitor\CommentAnnotatingVisitor;

#[Layout('components.layouts.admin-app')]
class CountryCrud extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $country_name, $country_code, $phone_code;
    public $countryId;
    public $showModal = false, $isEditing = false, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'Country';
    public $search = '';

    public function resetFields()
    {
        $this->reset([
            'country_name',
            'country_code',
            'phone_code',
            'countryId',
            'isEditing',
            'modalTitle'
        ]);
    }
    public function render()
    {
        $countries = Country::where('name', 'like', "%{$this->search}%")
            ->latest()->paginate(10);
        return view('livewire.admin.country-crud', compact('countries'));
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
            'country_name' => 'required',
            'country_code' => 'required|unique:countries,sortname|max:3',
            'phone_code' => 'required|numeric|max_digits:11',
        ]);

        Country::create([
            'sortname' => $this->country_code,
            'name' => $this->country_name,
            'phonecode' => $this->phone_code,
        ]);

        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
        $this->showModal = false;

    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $country = Country::findOrFail($id);
        $this->country_name = $country->name;
        $this->country_code = $country->sortname;
        $this->phone_code = $country->phonecode;

        $this->countryId = $country->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $country = Country::findOrFail($this->countryId);
        $country->update([
            'sortname' => $this->country_code,
            'name' => $this->country_name,
            'phonecode' => $this->phone_code,
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
        Country::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }

}
