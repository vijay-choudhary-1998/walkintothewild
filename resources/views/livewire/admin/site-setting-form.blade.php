<div class="container">

    <div class="row g-3">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item cursor-pointer @if ($step == 0) active @endif"
                            wire:click="$set('step', 0)">Personal Details</li>
                        <li class="list-group-item cursor-pointer @if ($step == 1) active @endif"
                            wire:click="$set('step', 1)">About Us</li>
                        <li class="list-group-item cursor-pointer @if ($step == 2) active @endif"
                            wire:click="$set('step', 2)">Term&Condition</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <form wire:submit="save">
                        @switch($step)
                            @case(1)
                                @include('livewire.admin.site-setting-forms.about-us')
                            @break

                            @case(2)
                                @include('livewire.admin.site-setting-forms.term-and-condition')
                            @break

                            @default
                                @include('livewire.admin.site-setting-forms.personal-details')
                        @endswitch
                        <div>
                            <button type="submit" class="btn btn-success">
                                Save
                                <i class="spinner-border spinner-border-sm" wire:loading></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
