<div>
    <form wire:submit="upload" class="mb-3">
        <input type="file" wire:model="photos" multiple class="form-control mb-2" accept="image/*">
        @error('photos.*') <div class="text-danger">{{ $message }}</div> @enderror

        <div class="row mb-2">
            @foreach ($previews as $preview)
                <div class="col-3 mb-2">
                    <img src="{{ $preview }}" class="img-fluid rounded border" style="max-height: 100px;">
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Upload Images
        </button>
    </form>

    @if ($imageIds)
        <div class="alert alert-success">
            Uploaded Image IDs: {{ implode(', ', $imageIds) }}
        </div>
    @endif
</div>
