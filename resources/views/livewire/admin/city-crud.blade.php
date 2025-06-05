<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ $pageTitle }} Management</h4>
            <button class="btn btn-primary" wire:click="openModal">Add {{ $pageTitle }}</button>
        </div>
        <div class="card-body">
            <div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search {{ $pageTitle }}..."
                    class="form-control mb-3 ms-auto" style="width:250px;">
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>State</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cities as $city)
                        <tr>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->state?->name ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    wire:click="edit({{ $city->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger"
                                    wire:click="confirmDelete({{ $city->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $cities->links() }}

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
                                            <label for="city_name" class="form-label">City Name</label>
                                            <input type="text" class="form-control" id="city_name"
                                                wire:model="city_name" placeholder="Enter city Name">
                                            @error('city_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="state" class="form-label">State</label>
                                            <select class="form-control" id="state" wire:model="state">
                                                <option value="">Select State</option>
                                                @foreach ($states as $stateId => $stateValue)
                                                    <option value="{{ $stateId }}">{{ $stateValue }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
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
