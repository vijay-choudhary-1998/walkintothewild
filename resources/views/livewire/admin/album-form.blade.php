<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Filter</h4>
        </div>
        <div class="card-body">
            <div class="row g-1 g-md-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                <div class="col">
                    <div class="form-group">
                        <select id="filter_category" class="form-select select2" wire:model="filter_category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $categoryId => $categoryValue)
                                <option value="{{ $categoryId }}">{{ $categoryValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <select id="filter_tag" class="form-select select2" wire:model="filter_tag">
                            <option value="">Select Tag</option>
                            @foreach ($tagsList as $tagId => $tagValue)
                                <option value="{{ $tagId }}">{{ $tagValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-info text-white rounded-0 me-2"
                        wire:click="$refresh">Apply</button>
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
            <div>
                <input type="text" class="form-control ms-auto mb-3" placeholder="Search"
                    wire:model.live.debounce.300ms="search" style="max-width:200px;">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th class="text-center">Images</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($albums as $index => $album)
                            <tr>
                                <td>{{ $albums->total() - ($albums->firstItem() + $index) + 1 }}</td>
                                <td>
                                    @if ($album->cover_image)
                                        <img src="{{ asset($album->cover_image) }}" width="60">
                                    @else
                                        <em>No image</em>
                                    @endif
                                </td>
                                <td>{{ $album->title }}</td>
                                <td>{{ $album->category->name ?? '-' }}</td>
                                <td>{{ $album->tags->pluck('name')->implode(', ') ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="cursor-pointer" wire:click="viewImages({{ $album->id }})">
                                        {{ $album->images()->count() }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        wire:click="edit({{ $album->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger"
                                        wire:click="confirmDelete({{ $album->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $albums->links() }}

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
                                <div class="mb-3">
                                    <label class="form-label">Album Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        wire:model.defer="title" placeholder="Enter title">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" wire:model.defer="description"
                                        placeholder="Enter description"></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                        wire:model.defer="category_id">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $categoryId => $categoryValue)
                                            <option value="{{ $categoryId }}">{{ $categoryValue }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tags -->
                                <div class="mb-3">
                                    <label class="form-label">Tags</label>
                                    <select multiple class="form-control @error('tags') is-invalid @enderror"
                                        wire:model.defer="tags">
                                        @foreach ($tagsList as $tagId => $tagValue)
                                            <option value="{{ $tagId }}">{{ $tagValue }}</option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Cover Image -->
                                <div class="mb-3">
                                    <label class="form-label">Cover Image</label>
                                    <input type="file"
                                        class="form-control @error('cover_image') is-invalid @enderror"
                                        wire:model="cover_image">
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if ($existingCover)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $existingCover) }}" width="120">
                                        </div>
                                    @endif
                                </div>

                                <!-- Multiple Images -->
                                <div class="mb-3">
                                    <label class="form-label">Upload Images (Multiple)</label>
                                    <input type="file"
                                        class="form-control @error('new_images.*') is-invalid @enderror"
                                        wire:model="new_images" multiple>
                                    @error('new_images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

            <!-- Modal -->
            <div class="modal @if ($viewModal) show @endif" tabindex="-1"
                style="opacity:1; background-color:#0606068c; display:@if ($viewModal) block @endif">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ $modalTitle }}</h4>
                            <button type="button" class="btn-close" wire:click="$set('viewModal', false)"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4">
                                @foreach ($albumImages as $image)
                                    <div class="col">
                                        <img src="{{ asset($image) }}" alt="" class="img-fluid">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('viewModal', false)"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
