<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" wire:model="title" class="form-control" placeholder="Enter title">
        @error('title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Safari Park <span class="text-danger">*</span></label>
        <select wire:model="safariPark" id="safariPark" name="safariPark" class="form-select">
            <option value="">-- Select Park --</option>
            @foreach ($safariParks as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        @error('safariPark')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Start Date <span class="text-danger">*</span></label>
        <input type="date" wire:model.live="start_date" id="start_date" name="start_date" class="form-control" min="{{ now()->format('Y-m-d') }}"
            onclick="this.showPicker && this.showPicker()" wire:change="$set('end_date', '')">
        @error('start_date')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">End Date <span class="text-danger">*</span></label>
        <input type="date" wire:model="end_date" id="end_date" name="end_date" class="form-control"
            min="{{ $start_date ?? now()->format('Y-m-d') }}" onclick="this.showPicker && this.showPicker()">
        @error('end_date')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-12">
        <label for="safari_no" class="form-label">Number Of Safari <span class="text-danger">*</span></label>
        <input type="range" class="form-range" min="1" max="10" name="safari_no" id="safari_no"
            wire:model="safari_no" onchange="safariNumber(this)">
        <p>No. of Safaris: <span id="safariNumber" class="fw-bold">{{ $safari_no }}</span></p>
        @error('safari_no')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
