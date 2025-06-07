<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Filter</h4>
        </div>
        <div class="card-body">
            <div class="row g-1 g-md-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search"
                        wire:model.live.debounce.300ms="search">
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_wildlife" class="form-select select2" wire:model.live="filter_wildlife">
                            <option value="">Select Wildlife</option>
                            @foreach ($wildlives as $wildlifeId => $wildlifeValue)
                                <option value="{{ $wildlifeId }}">{{ $wildlifeValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_country" class="form-select select2" wire:model.live="filter_country">
                            <option value="">Select Country</option>
                            @foreach ($countries as $countryId => $countryValue)
                                <option value="{{ $countryId }}">{{ $countryValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_state" class="form-select select2" wire:model.live="filter_state">
                            <option value="">Select State</option>
                            @foreach ($filter_states as $stateId => $stateValue)
                                <option value="{{ $stateId }}">{{ $stateValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_city" class="form-select select2" wire:model.live="filter_city">
                            <option value="">Select City</option>
                            @foreach ($filter_cities as $cityId => $cityValue)
                                <option value="{{ $cityId }}">{{ $cityValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
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
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Wildlife</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($parks as $index => $park)
                            <tr>
                                <td>{{ $parks->total() - ($parks->firstItem() + $index) + 1 }}</td>
                                <td>{{ $park->title }}</td>
                                <td>{{ $park->wildlife->name ?? '-' }}</td>
                                <td>{{ $park->city->name ?? '-' }}</td>
                                <td>{{ $park->state->name ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        wire:click="edit({{ $park->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger"
                                        wire:click="confirmDelete({{ $park->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $parks->links() }}

            <!-- Modal -->
            <div class="modal @if ($showModal) show @endif" tabindex="-1"
                style="opacity:1; background-color:#0606068c; display:@if ($showModal) block @endif">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $modalTitle }}</h4>
                                <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">

                                    <!-- Title -->
                                    <div class="col-12">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            wire:model="title" placeholder="Enter title">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Short Description -->
                                    <div class="col-md-12">
                                        <label class="form-label">Short Description</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" wire:model="short_description"
                                            placeholder="Enter short description"></textarea>
                                        @error('short_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description"
                                            placeholder="Enter description"></textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Country -->
                                    <div class="col-md-6">
                                        <label class="form-label">Country</label>
                                        <select class="form-control @error('country_id') is-invalid @enderror"
                                            wire:model.live="country_id">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $countryId => $countryValue)
                                                <option value="{{ $countryId }}">{{ $countryValue }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- State -->
                                    <div class="col-md-6">
                                        <label class="form-label">State</label>
                                        <select class="form-control @error('state_id') is-invalid @enderror"
                                            wire:model.live="state_id">
                                            <option value="">Select State</option>
                                            @foreach ($states as $stateId => $stateValue)
                                                <option value="{{ $stateId }}">{{ $stateValue }}</option>
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- City -->
                                    <div class="col-md-6">
                                        <label class="form-label">City</label>
                                        <select class="form-control @error('city_id') is-invalid @enderror"
                                            wire:model="city_id">
                                            <option value="">Select City</option>
                                            @foreach ($cities as $cityId => $cityValue)
                                                <option value="{{ $cityId }}">{{ $cityValue }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Train -->
                                    <div class="col-md-6">
                                        <label class="form-label">Train</label>
                                        <input type="text" class="form-control @error('train') is-invalid @enderror"
                                            wire:model="train" placeholder="Enter nearest train station">
                                        @error('train')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Airport -->
                                    <div class="col-md-6">
                                        <label class="form-label">Airport</label>
                                        <input type="text"
                                            class="form-control @error('airport') is-invalid @enderror"
                                            wire:model="airport" placeholder="Enter nearest airport">
                                        @error('airport')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Safari Session -->
                                    <div class="col-md-6">
                                        <label class="form-label">Safari Session</label>
                                        <input type="text"
                                            class="form-control @error('safari_session') is-invalid @enderror"
                                            wire:model="safari_session" placeholder="Enter safari session details">
                                        @error('safari_session')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Wildlife Found -->
                                    <div class="col-md-6">
                                        <label class="form-label">Wildlife Found</label>
                                        <select class="form-control @error('wildlife_found') is-invalid @enderror"
                                            wire:model="wildlife_found">
                                            <option value="">Select Wildlife</option>
                                            @foreach ($wildlives as $wildlifeId => $wildlifeValue)
                                                <option value="{{ $wildlifeId }}">{{ $wildlifeValue }}</option>
                                            @endforeach
                                        </select>
                                        @error('wildlife_found')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Safari Cost -->
                                    <div class="col-md-6">
                                        <label class="form-label">Safari Cost</label>
                                        <input type="text"
                                            class="form-control @error('safari_cost') is-invalid @enderror"
                                            wire:model="safari_cost" placeholder="Enter safari cost">
                                        @error('safari_cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Safari Mode -->
                                    <div class="col-md-6">
                                        <label class="form-label">Safari Mode</label>
                                        <input type="text"
                                            class="form-control @error('safari_mode') is-invalid @enderror"
                                            wire:model="safari_mode" placeholder="Enter safari mode">
                                        @error('safari_mode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Closed Months -->
                                    <select class="form-control @error('closed_months') is-invalid @enderror" multiple
                                        wire:model="closed_months">
                                        @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                    <i class="spinner-border spinner-border-sm" wire:loading></i>
                                </button>
                                <button type="button" class="btn btn-secondary"
                                    wire:click="$set('showModal', false)" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
