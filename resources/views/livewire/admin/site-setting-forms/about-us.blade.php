<div class="mb-3">
    <label for="about_us" class="form-label">About Us</label>
    <textarea name="about_us" id="about_us" wire:model="key.about_us" class="form-control @error('key.about_us') is-invalid @enderror" placeholder="Enter About Us"></textarea>
    @error('key.about_us')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
