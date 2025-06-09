<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Purpose of Visit <span class="text-danger">*</span></label>
        <select wire:model="visit_purpose_id" class="form-select select2" id="visit_purpose_id" placeholder="Select Visit Purpose">
            <option value="">Select a purpose</option>
            @foreach ($visitPurposes as $id => $label)
                <option value="{{ $id }}">{{ $label }}</option>
            @endforeach
        </select>
        @error('visit_purpose_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Stay Category <span class="text-danger">*</span></label>
        <select wire:model="stay_category_id" class="form-select select2" id="stay_category_id" placeholder="Select Staty Category">
            <option value="">Select a category</option>
            @foreach ($stayCategories as $id => $label)
                <option value="{{ $id }}">{{ $label }}</option>
            @endforeach
        </select>
        @error('stay_category_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-12">
        <label for="min_price_pp" class="form-label">Price Per Person(INR) <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="number" name="min_price_pp" id="min_price_pp" wire:model="min_price_pp"
                oninput="minPricePPChange(this)" min="1" step="1" class="form-control" placeholder="MIN">
            <span class="input-group-text">-</span>
            <input type="number" name="max_price_pp" id="max_price_pp" wire:model="max_price_pp" min="1"
                step="1" class="form-control" placeholder="MAX">
        </div>
        @error('min_price_pp')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        @error('max_price_pp')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Total Seats <span class="text-danger">*</span></label>
        <input type="number" name="total_seats" id="total_seats" wire:model.live="total_seats"
            oninput="totalSeatsChange(this)" min="1" step="1" class="form-control"
            placeholder="Total Seats">
        @error('total_seats')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Share Seats <span class="text-danger">*</span></label>
        <select name="share_seats" id="share_seats" class="form-select select2" wire:model="share_seats" placeholder="Select Share Seats">
            <option value="">Select</option>
            {{-- @if ($isEditing) --}}
            @for ($i = 1; $i < $total_seats; $i++)
                <option value="{{$i}}" @selected($i == $share_seats)>{{$i}}</option>
            @endfor
            {{-- @endif --}}
        </select>
        @error('share_seats')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
