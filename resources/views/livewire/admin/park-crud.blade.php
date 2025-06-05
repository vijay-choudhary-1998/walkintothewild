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
                        <th>Title</th>
                        <th>Slug</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parks as $park)
                        <tr>
                            <td>{{ $park->title }}</td>
                            <td>{{ $park->slug }}</td>
                            <td>{{ $park->city }}</td>
                            <td>{{ $park->state }}</td>
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
                                    @foreach (['title', 'slug', 'short_description', 'description', 'city', 'state', 'country', 'train', 'airport', 'safari_session', 'wildlife_found', 'safari_cost', 'safari_mode', 'closed_months'] as $field)
                                        <div
                                            class="col-md-{{ in_array($field, ['short_description', 'description']) ? '12' : '6' }}">
                                            <label
                                                class="form-label text-capitalize">{{ str_replace('_', ' ', $field) }}</label>
                                            @if (in_array($field, ['short_description', 'description']))
                                                <textarea class="form-control @error($field) is-invalid @enderror" wire:model.defer="{{ $field }}"></textarea>
                                            @else
                                                <input type="text"
                                                    class="form-control @error($field) is-invalid @enderror"
                                                    wire:model.defer="{{ $field }}">
                                            @endif
                                            @error($field)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
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
