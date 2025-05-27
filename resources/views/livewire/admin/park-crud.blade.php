<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Park Management</h2>

            <button class="btn btn-primary mb-3" wire:click="openModal">Add Park</button>

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
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $park->id }})"
                                    onclick="return confirm('Delete this park?')">Delete</button>
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


            {{-- <div class="modal fade" id="parkModal" tabindex="-1" aria-labelledby="parkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <input type="text" class="form-control @error($field) is-invalid @enderror"
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
                        <button type="submit" class="btn btn-success">{{ $isEditing ? 'Update' : 'Save' }}</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
        </div>
    </div>
</div>

{{-- @script
    <script>
        window.addEventListener('show-form', () => {
            new bootstrap.Modal(document.getElementById('parkModal')).show();
        });
        window.addEventListener('hide-form', () => {
            bootstrap.Modal.getInstance(document.getElementById('parkModal')).hide();
        });
    </script>
@endscript --}}
