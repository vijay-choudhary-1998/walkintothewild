<div class="mb-3">
    <label for="term_and_condition" class="form-label">Term & Condition</label>
    <textarea name="term_and_condition" id="term_and_condition" wire:model="key.term_and_condition" class="form-control @error('key.term_and_condition') is-invalid @enderror" placeholder="Term & Condition" rows="15"></textarea>
    @error('key.term_and_condition')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
