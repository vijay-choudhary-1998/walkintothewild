<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                {{$errors}}
            @endif

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Site Settings</h4>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="save">

                        <div class="mb-3">
                            <label class="form-label">Site Name</label>
                            <input type="text" class="form-control @error('key.site_name') is-invalid @enderror"
                                   wire:model="key.site_name">
                            @error('key.site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Site Email</label>
                            <input type="email" class="form-control @error('key.site_email') is-invalid @enderror"
                                   wire:model="key.site_email">
                            @error('key.site_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Footer Text</label>
                            <textarea class="form-control" rows="3" wire:model="key.footer_text"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Site Logo</label>
                            <input type="file" class="form-control" wire:model="site_logo">

                            @if ($key['existing_logo'])
                                <div class="mt-2">
                                    <label>Current Logo:</label><br>
                                    <img src="{{ asset('storage/' . $key['existing_logo']) }}" width="120" class="img-thumbnail">
                                </div>
                            @endif

                            @error('site_logo') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Settings
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
