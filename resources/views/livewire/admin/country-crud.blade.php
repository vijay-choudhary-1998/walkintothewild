<div class="container">
    <div class="card">
        <div class="card-body">
            <h3>Country Management</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>{{ $isEditing ? 'Edit' : 'Create' }} Country</h5>
        </div>
        <div class="card-body">
            <form wire:submit="{{ $isEditing ? 'update' : 'submit' }}">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="country_name" class="form-label">Country Name</label>
                            <input type="text" class="form-control" id="country_name" wire:model="country_name"
                                placeholder="Enter Country Name">
                            @error('country_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="country_code" class="form-label">Country Code</label>
                            <input type="text" class="form-control" id="country_code" wire:model="country_code"
                                placeholder="Enter Country Code">
                            @error('country_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="phone_code" class="form-label">Phone Code</label>
                            <input type="text" class="form-control" id="phone_code" wire:model="phone_code"
                                placeholder="Enter Country Phone Code">
                            @error('phone_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">Add Country</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Country List</h5>
        </div>
        <div class="card-body">
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
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $country->id }})"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $countries->links() }}

        </div>
    </div>
</div>
