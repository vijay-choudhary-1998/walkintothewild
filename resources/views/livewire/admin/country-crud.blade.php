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
                        <th>Country Code</th>
                        <th>Phone Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countries as $country)
                        <tr>
                            <td>{{ $country->name }}</td>
                            <td>{{ $country->sortname ?? '-' }}</td>
                            <td>{{ $country->phonecode ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    wire:click="edit({{ $country->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger"
                                    wire:click="confirmDelete({{ $country->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $countries->links() }}

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
                                            <label for="country_name" class="form-label">Country Name</label>
                                            <input type="text" class="form-control" id="country_name"
                                                wire:model="country_name" placeholder="Enter Country Name">
                                            @error('country_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="country_code" class="form-label">Country Code</label>
                                            <input type="text" class="form-control" id="country_code"
                                                wire:model="country_code" placeholder="Enter Country Code">
                                            @error('country_code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="phone_code" class="form-label">Phone Code</label>
                                            <input type="text" class="form-control" id="phone_code"
                                                wire:model="phone_code" placeholder="Enter Country Phone Code">
                                            @error('phone_code')
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
