<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Wildlife Management</h2>

            <button class="btn btn-primary mb-3" wire:click="openModal">Add Wildlife</button>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Species</th>
                        <th>Habitat</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wildlifes as $wildlife)
                        <tr>
                            <td>{{ $wildlife->name }}</td>
                            <td>{{ $wildlife->species }}</td>
                            <td>{{ $wildlife->habitat }}</td>
                            <td>{{ $wildlife->description }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    wire:click="edit({{ $wildlife->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $wildlife->id }})"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $wildlifes->links() }}

            <!-- Modal -->
            <div class="modal fade" id="wildlifeModal" tabindex="-1" aria-labelledby="wildlifeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $modalTitle }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        wire:model.defer="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Species</label>
                                    <input type="text" class="form-control @error('species') is-invalid @enderror"
                                        wire:model.defer="species">
                                    @error('species')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Habitat</label>
                                    <input type="text" class="form-control @error('habitat') is-invalid @enderror"
                                        wire:model.defer="habitat">
                                    @error('habitat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" wire:model.defer="description"></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit"
                                    class="btn btn-success">{{ $isEditing ? 'Update' : 'Save' }}</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        window.addEventListener('show-form', () => {
            new bootstrap.Modal(document.getElementById('wildlifeModal')).show();
        });

        window.addEventListener('hide-form', () => {
            bootstrap.Modal.getInstance(document.getElementById('wildlifeModal')).hide();
        });
    </script>
@endscript
