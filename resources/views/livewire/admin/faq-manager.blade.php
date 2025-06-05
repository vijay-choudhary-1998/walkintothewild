<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>FAQ Management</h4>
            <button class="btn btn-primary" wire:click="openModal">Add FAQ</button>
        </div>
        <div class="card-body">
            <div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search FAQ..."
                    class="form-control mb-3 ms-auto" style="width:250px;">
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($faqs as $faq)
                        <tr>
                            <td>{{ $faq->category->name ?? '-' }}</td>
                            <td>{{ $faq->question }}</td>
                            <td>{{ Str::limit($faq->answer, 100) }}</td>
                            <td>
                                <button wire:click="toggleStatus({{ $faq->id }})"
                                    class="btn btn-sm {{ $faq->status ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $faq->status ? 'Active' : 'Inactive' }}
                                </button>
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
                                        <select  class="form-control select2 @error('category_id') is-invalid @enderror"
                                            wire:model="category_id" id="category_id" name="category_id">
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
