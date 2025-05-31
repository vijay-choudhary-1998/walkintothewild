<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SiteSetting;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin-app')]
class SiteSettingForm extends Component
{
    use WithFileUploads;

    public $site_name, $site_email, $footer_text, $site_logo, $existing_logo;

    public $key = [], $value = [];
    public function mount()
    {
        $setting = SiteSetting::pluck('value', 'key');

        if ($setting) {
            $this->key['site_name'] = $setting['site_name'] ?? '';
            $this->key['site_email'] = $setting['site_email'] ?? '';
            $this->key['footer_text'] = $setting['footer_text'] ?? '';
            $this->key['existing_logo'] = $setting['site_logo'] ?? '';
        }
    }
    public function save()
    {
        $this->validate([
            'key' => 'required|array',
            'key.site_name' => 'required|string|max:255',
            'key.site_email' => 'required|email|max:255',
            'key.footer_text' => 'nullable|string',
            'site_logo' => 'nullable|image|max:2048',
        ]);

        // dd($this->key);

        $logoPath = $this->key['existing_logo'];
        if ($this->site_logo) {
            $logoPath = $this->site_logo->store('site-logos', 'public');
        }

        $this->key['site_logo'] = $logoPath;

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
    public function render()
    {
        return view('livewire.admin.site-setting-form');
    }
}
