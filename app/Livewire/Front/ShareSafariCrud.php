<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Livewire\WithPagination;

class ShareSafariCrud extends Component
{
    use WithPagination;
    public $showModal = false,$isEditing = false;
    public $modalTitle = 'Add Park';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.front.share-safari-crud');
    }
}
