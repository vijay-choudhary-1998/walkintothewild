<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Filter</h4>
        </div>
        <div class="card-body">
            <div class="row g-1 g-md-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                <div class="col">
                    <div class="form-group">
                        <select id="filter_category" class="form-select select2" wire:model="filter_category"
                            placeholder="Select Category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category_id => $category_value)
                                <option value="{{ $category_id }}">{{ $category_value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
                    <button type="button" class="btn btn-info text-white rounded-0 me-2"
                        wire:click="applyFilter">Apply</button>
                    <button type="button" class="btn btn-info text-white rounded-0"
                        wire:click="resetFilter">Clear</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>FAQ Management</h4>
            <button class="btn btn-primary" wire:click="openModal">Add FAQ</button>
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
                            <th>Category</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $index => $faq)
                            <tr wire:key="{{ $index }}">
                                <td>{{ $faqs->total() - ($faqs->firstItem() + $index) + 1 }}</td>
                                <td>{{ $faq->category->name ?? '-' }}</td>
                                <td>{{ $faq->question }}</td>
                                <td>{{ Str::limit($faq->answer, 100) }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            wire:change="toggleStatus({{ $faq->id }})"
                                            @checked($faq->status)>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        wire:click="edit({{ $faq->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger"
                                        wire:click="confirmDelete({{ $faq->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $faqs->links() }}

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
                                    <div class="col-md-12">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                            wire:model="category_id" id="category_id" name="category_id"
                                            placeholder="Select Category">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $categoryID => $categoryValue)
                                                <option value="{{ $categoryID }}">{{ $categoryValue }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="question" class="form-label">Question</label>
                                        <input type="text"
                                            class="form-control @error('question') is-invalid @enderror"
                                            wire:model="question" placeholder="Enter Question Here...">
                                        @error('question')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="answer" class="form-label">Answer</label>
                                        <textarea class="form-control @error('answer') is-invalid @enderror" wire:model="answer"
                                            placeholder="Enter Answer Here..."></textarea>
                                        @error('answer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
