<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Filter</h4>
        </div>
        <div class="card-body">
            <div class="row g-1 g-md-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                <div class="col">
                    <div class="form-group">
                        <select id="filter_country" class="form-select select2" wire:model="filter_country">
                            <option value="">Select Country</option>
                            @foreach ($countries as $countryId => $countryValue)
                                <option value="{{ $countryId }}">{{ $countryValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
                    <button type="button" class="btn btn-info text-white rounded-0 me-2"
                        wire:click="$refresh">Apply</button>
                    <button type="button" class="btn btn-info text-white rounded-0"
                        wire:click="resetFilter">Clear</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ $pageTitle }} Management</h4>
            <button class="btn btn-primary" wire:click="openModal">Add {{ $pageTitle }}</button>
        </div>
        <div class="card-body">
            <div>
                <input type="text" class="form-control ms-auto mb-3" placeholder="Search"
                    wire:model.live.debounce.300ms="search" style="max-width:200px;">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Country Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $index => $state)
                            <tr>
                                <td>{{ $states->total() - ($states->firstItem() + $index) + 1 }}</td>
                                <td>{{ $state->name }}</td>
                                <td>{{ $state->country?->name ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        wire:click="edit({{ $state->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger"
                                        wire:click="confirmDelete({{ $state->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $states->links() }}

            <!-- Modal -->
            <div class="modal @if ($showModal) show @endif" tabindex="-1"
                style="opacity:1; background-color:#0606068c; display:@if ($showModal) block @endif">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'submit' }}">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $modalTitle }}</h4>
                                <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="state_name" class="form-label">State Name</label>
                                            <input type="text" class="form-control" id="state_name"
                                                wire:model="state_name" placeholder="Enter state Name">
                                            @error('state_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="country" class="form-label">Country</label>
                                            <select class="form-control" id="country" wire:model="country">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $countryId => $countryValue)
                                                    <option value="{{ $countryId }}">{{ $countryValue }}</option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                    <i class="spinner-border spinner-border-sm" wire:loading></i>
                                </button>
                                <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
