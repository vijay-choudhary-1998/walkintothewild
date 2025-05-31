<div class="container">
    <div class="card">
        <div class="card-body">
            <h3>City Management</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>{{ $isEditing ? 'Edit' : 'Create' }} City</h5>
        </div>
        <div class="card-body">
            <form wire:submit="{{ $isEditing ? 'update' : 'submit' }}">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="city_name" class="form-label">City Name</label>
                            <input type="text" class="form-control" id="city_name" wire:model="city_name"
                                placeholder="Enter city Name">
                            @error('city_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
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
                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">Add City</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>City List</h5>
        </div>
        <div class="card-body">
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
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $city->id }})"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $cities->links() }}

        </div>
    </div>
</div>
