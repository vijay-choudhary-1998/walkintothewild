<div class="container">
    <div class="card">
        <div class="card-body">
            <h3>State Management</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>{{ $isEditing ? 'Edit' : 'Create' }} State</h5>
        </div>
        <div class="card-body">
            <form wire:submit="{{ $isEditing ? 'update' : 'submit' }}">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="state_name" class="form-label">State Name</label>
                            <input type="text" class="form-control" id="state_name" wire:model="state_name"
                                placeholder="Enter state Name">
                            @error('state_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-control" id="country" wire:model="country">
                                <option value="">Select Country</option>
                                @foreach ($countries as $countryId => $countryValue)
                                    <option value="{{$countryId}}">{{$countryValue}}</option>
                                @endforeach
                            </select>
                            @error('country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">Add State</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>State List</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Country Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($states as $state)
                        <tr>
                            <td>{{ $state->name }}</td>
                            <td>{{ $state->country?->name ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    wire:click="edit({{ $state->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $state->id }})"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $states->links() }}

        </div>
    </div>
</div>
