<?php

namespace App\Livewire\Admin;

use App\Helpers\ImageHelper;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SiteSetting;
use App\Models\Upload;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin-app')]
class SiteSettingForm extends Component
{
    use WithFileUploads;

    public $site_name, $site_email, $footer_text, $site_logo, $existing_logo;

    public $key = [], $value = [];
    public $step = 0;
    public $settings;

    public function mount()
    {
        $this->settings = $settings = SiteSetting::pluck('value', 'key');

        if ($this->settings) {
            $this->key['site_name'] = $settings['site_name'] ?? '';
            $this->key['site_email'] = $settings['site_email'] ?? '';
            $this->key['footer_text'] = $settings['footer_text'] ?? '';
            $this->key['existing_logo'] = $settings['site_logo'] ?? '';
        }
    }
    public function updatedStep($value)
    {
        if ($settings = $this->settings) {

            $this->reset('key');

            switch ($value) {
                case 1:
                    $this->key['about_us'] = $settings['about_us'] ?? '';
                    break;
                case 2:
                    $this->key['term_and_condition'] = $settings['term_and_condition'] ?? '';
                    break;

                default:
                    $this->key['site_name'] = $settings['site_name'] ?? '';
                    $this->key['site_email'] = $settings['site_email'] ?? '';
                    $this->key['footer_text'] = $settings['footer_text'] ?? '';
                    $this->key['existing_logo'] = $settings['site_logo'] ?? '';
                    break;
            }
        }
    }
    public function save()
    {
        $this->validate($this->rules());

        if ($this->step == 0) {

            if (($this->site_logo)) {
                $image = $this->site_logo;
                $path = 'uploads/site-logos';
                $origPath = $image->store($path, 'public_root');

                $avifPath = '';
                $avifPath = ImageHelper::convertToAvif($origPath, $path);

                $upload = Upload::create([
                    'original_name' => $image->getClientOriginalName(),
                    'avif_path' => $avifPath,
                ]);

                $logoPath = $avifPath;
            } else {
                $logoPath = $this->key['existing_logo'];
            }

            $this->key['site_logo'] = $this->key['existing_logo'] = $logoPath;
        }

        foreach ($this->key as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                ]
            );
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Settings updated successfully.']);
    }

    public function rules()
    {
        return match ($this->step) {
            0 => [
                'key' => 'required|array',
                'key.site_name' => 'required|string|max:255',
                'key.site_email' => 'required|email|max:255',
                'key.footer_text' => 'nullable|string',
                'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            1 => [
                'key' => 'required|array',
                'key.about_us' => 'required|string',
            ],
            2 => [
                'key' => 'required|array',
                'key.term_and_condition' => 'required|string',
            ],
        };
    }
    public function render()
    {
        return view('livewire.admin.site-setting-form');
    }
}
