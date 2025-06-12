<div>
    <form wire:submit.prevent="uploadImages">
        <input type="file" wire:model="images" {{ $multiple ? 'multiple' : '' }}>

        @error('images.*')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="row mt-3">
            @foreach ($images as $index => $image)
                <div class="col-md-3 mb-3">
                    <div class="position-relative border rounded p-2 text-center">
                        @if ($image->temporaryUrl())
                            <img src="{{ $image->temporaryUrl() }}" class="img-fluid" style="max-height: 150px;">
                        @endif
                        <button type="button" class="btn btn-sm btn-danger mt-2"
                            wire:click.prevent="removeImage({{ $index }})">
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($images)
            <button class="btn btn-primary mt-3">Upload {{ $multiple ? 'Images' : 'Image' }}</button>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
    </form>
</div>
