<div>
    <div class="card">
        <div class="card-header">
            <h4>{{ $pageTitle }} Management</h4>
        </div>
        <div class="card-body">
            <livewire:components.ckeditor :editor_text="$editorText" />
            <div class="mb-3">
                <span class="text-danger">{{$error}}</span>
            </div>
            <div>
                <button class="btn btn-primary" wire:loading.attr="disabled" wire:click="save" wire:target="save">
                    Update
                    <i class="spinner-border spinner-border-sm" wire:loading wire:target="save"></i>
                </button>
                <button class="btn btn-warning" wire:loading.attr="disabled" wire:target.except="save">
                    Preview
                    <i class="spinner-border spinner-border-sm" wire:loading wire:target.except="save"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Preview</h4>
        </div>
        <div class="card-body">
            {!! $editorText !!}
        </div>
    </div>
</div>
