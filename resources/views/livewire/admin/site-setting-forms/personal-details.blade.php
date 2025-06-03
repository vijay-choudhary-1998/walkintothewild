<div class="mb-3">
    <label class="form-label">Site Name</label>
    <input type="text" class="form-control @error('key.site_name') is-invalid @enderror" wire:model="key.site_name">
    @error('key.site_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Site Email</label>
    <input type="email" class="form-control @error('key.site_email') is-invalid @enderror" wire:model="key.site_email">
    @error('key.site_email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Footer Text</label>
    <textarea class="form-control" rows="3" wire:model="key.footer_text"></textarea>
</div>

<div class="mb-3">
    <div class="row">
        <div class="col-md-8">
            <label class="form-label">Site Logo</label>
            <input type="file" class="form-control" wire:model="site_logo">
        </div>
        <div class="col-md-4">
            @if ($site_logo)
                <img src="{{ $site_logo->temporaryUrl() }}" class="img-fluid h-100 object-fit-contain">
            @elseif(!empty($key['existing_logo']))
                <img src="{{ asset($key['existing_logo']) }}" class="img-fluid h-100 object-fit-contain">
            @else
                <span class="text-muted">No Image Selected</span>
            @endif
        </div>
    </div>

    @error('site_logo')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
