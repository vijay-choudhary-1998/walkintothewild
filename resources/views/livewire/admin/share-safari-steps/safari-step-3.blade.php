<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Safari Plan <span class="text-danger">*</span></label>
        <textarea wire:model="safari_plan" rows="4" class="form-control" placeholder="Enter safari plan"></textarea>
        @error('safari_plan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Upload Display Image <span class="text-danger">*</span></label>
        <input type="file" wire:model="display_image" class="form-control">
        @error('display_image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">{{ $isEditing ? 'Current' : 'Preview' }}</label>
        <div class="border bg-light text-center p-2" style="height: 200px;">
            @if ($display_image)
                <img src="{{ $display_image->temporaryUrl() }}" class="img-fluid h-100 object-fit-contain">
            @elseif($isEditing && !empty($previousImage))
                <img src="{{ asset($previousImage) }}" class="img-fluid h-100 object-fit-contain">
            @else
                <span class="text-muted">No Image Selected</span>
            @endif
        </div>
    </div>
</div>
