<?php

namespace App\Livewire\Admin;

use App\Helpers\ImageHelper;
use App\Models\{Park, ShareSafari, StayCategory, Upload, VisitPurpose};
use Livewire\Attributes\{Layout, On};
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class ShareSafariCrud extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $showModal = false, $isEditing = false, $editId, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'Share Safari';
    public $search = '';
    public $step = 1;

    public $title, $safariPark, $start_date, $end_date, $safari_no = 1;
    public $visit_purpose_id, $stay_category_id, $min_price_pp, $max_price_pp, $total_seats, $share_seats;
    public $safari_plan, $display_image, $previousImage;
    public $safariParks, $visitPurposes, $stayCategories;
    public $filter_park, $filter_visitPurposes, $filter_stayCategories;
    public $filter_park_temp, $filter_visitPurposes_temp, $filter_stayCategories_temp;
    public $uploaded_images = [];

    public function mount()
    {
        $this->safariParks = Park::pluck('title', 'id');
        $this->visitPurposes = VisitPurpose::pluck('name', 'id');
        $this->stayCategories = StayCategory::pluck('name', 'id');
    }
    public function render()
    {

        $shareSafaries = ShareSafari::where('title', 'like', "%{$this->search}%");
        if (isset($this->filter_park_temp) && !empty($this->filter_park_temp)) {
            $shareSafaries->where('safari_park_id', $this->filter_park_temp);
        }
        if (isset($this->filter_visitPurposes_temp) && !empty($this->filter_visitPurposes_temp)) {
            $shareSafaries->where('visit_purpose_id', $this->filter_visitPurposes_temp);
        }
        if (isset($this->filter_stayCategories_temp) && !empty($this->filter_stayCategories_temp)) {
            $shareSafaries->where('stay_category_id', $this->filter_stayCategories_temp);
        }

        $shareSafaries = $shareSafaries->latest()->paginate(10);


        return view('livewire.admin.share-safari-crud', compact('shareSafaries'));
    }
    public function applyFilter()
    {
        $this->filter_park_temp = $this->filter_park;
        $this->filter_visitPurposes_temp = $this->filter_visitPurposes;
        $this->filter_stayCategories_temp = $this->filter_stayCategories;
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_park', 'filter_visitPurposes', 'filter_stayCategories', 'filter_park_temp', 'filter_visitPurposes_temp', 'filter_stayCategories_temp']);
    }


    public function nextStep()
    {
        $this->validate($this->rules());
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function resetFields()
    {
        $this->reset([
            'title',
            'safariPark',
            'start_date',
            'end_date',
            'safari_no',
            'visit_purpose_id',
            'stay_category_id',
            'min_price_pp',
            'max_price_pp',
            'total_seats',
            'share_seats',
            'safari_plan',
            'display_image',
            'previousImage',
            'editId',
            'deleteId',
            'step',
        ]);
        $this->resetValidation();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->showModal = true;
    }


    public function store()
    {
        $this->validate($this->rules());

        $image = $this->display_image;
        $path = 'uploads/sharesafarie';
        $origPath = $image->store($path, 'public_root');

        $avifPath = '';
        $avifPath = ImageHelper::convertToAvif($origPath, $path);

        $upload = Upload::create([
            'original_name' => $image->getClientOriginalName(),
            'avif_path' => $avifPath,
        ]);

        $imagePath = $avifPath;


        ShareSafari::create([
            'title' => $this->title,
            'safari_park_id' => $this->safariPark,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'no_of_safari' => $this->safari_no,
            'visit_purpose_id' => $this->visit_purpose_id,
            'stay_category_id' => $this->stay_category_id,
            'min_price_pp' => $this->min_price_pp,
            'max_price_pp' => $this->max_price_pp,
            'total_seats' => $this->total_seats,
            'share_seats' => $this->share_seats,
            'safari_plan' => $this->safari_plan,
            'display_image' => $imagePath,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);

        $this->showModal = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->resetFields();
        $shareSafari = ShareSafari::findOrFail($id);

        $this->title = $shareSafari->title;
        $this->safariPark = $shareSafari->safari_park_id;
        $this->start_date = $shareSafari->start_date;
        $this->end_date = $shareSafari->end_date;
        $this->safari_no = $shareSafari->no_of_safari;
        $this->visit_purpose_id = $shareSafari->visit_purpose_id;
        $this->stay_category_id = $shareSafari->stay_category_id;
        $this->min_price_pp = $shareSafari->min_price_pp;
        $this->max_price_pp = $shareSafari->max_price_pp;
        $this->total_seats = $shareSafari->total_seats;
        $this->share_seats = $shareSafari->share_seats;
        $this->safari_plan = $shareSafari->safari_plan;
        $this->previousImage = $shareSafari->display_image;

        $this->editId = $shareSafari->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $shareSafari = ShareSafari::findOrFail($this->editId);
        if (($this->display_image)) {
            $image = $this->display_image;
            $path = 'uploads/sharesafarie';
            $origPath = $image->store($path, 'public_root');

            $avifPath = '';
            $avifPath = ImageHelper::convertToAvif($origPath, $path);

            $upload = Upload::create([
                'original_name' => $image->getClientOriginalName(),
                'avif_path' => $avifPath,
            ]);

            $imagePath = $avifPath;
        } else {
            $imagePath = $this->previousImage;
        }

        $shareSafari->update([
            'title' => $this->title,
            'safari_park_id' => $this->safariPark,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'no_of_safari' => $this->safari_no,
            'visit_purpose_id' => $this->visit_purpose_id,
            'stay_category_id' => $this->stay_category_id,
            'min_price_pp' => $this->min_price_pp,
            'max_price_pp' => $this->max_price_pp,
            'total_seats' => $this->total_seats,
            'share_seats' => $this->share_seats,
            'safari_plan' => $this->safari_plan,
            'display_image' => $imagePath,
        ]);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
        $this->showModal = false;
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
        ShareSafari::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return match ($this->step) {
            1 => [
                'title' => 'required|string',
                'safariPark' => 'required',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'safari_no' => 'required|integer|min:1|max:10',
            ],
            2 => [
                'visit_purpose_id' => 'required',
                'stay_category_id' => 'required',
                'min_price_pp' => 'required|numeric|min:1',
                'max_price_pp' => ['required', 'numeric', 'gte:' . (is_numeric((int) $this->min_price_pp) ? (int) $this->min_price_pp : 1)],
                'total_seats' => 'required|numeric|min:1',
                'share_seats' => 'required',
            ],
            3 => [
                'safari_plan' => 'required|string',
                'display_image' => ($this->editId && !empty($this->previousImage)) ? 'nullable||image|mimes:jpg,jpeg,png,webp|max:2048' : 'required||image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
        };
    }
}
