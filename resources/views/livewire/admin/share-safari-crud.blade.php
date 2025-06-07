<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Filter</h4>
        </div>
        <div class="card-body">
            <div class="row g-1 g-md-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                <div class="col">
                    <div class="form-group">
                        <select id="filter_park" class="form-select select2" wire:model="filter_park">
                            <option value="">Select Park</option>
                            @foreach ($safariParks as $parkId => $parkValue)
                                <option value="{{ $parkId }}">{{ $parkValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_visitPurposes" class="form-select select2"
                            wire:model="filter_visitPurposes">
                            <option value="">Select Visit Purpose</option>
                            @foreach ($visitPurposes as $visitPurposesId => $visitPurposesValue)
                                <option value="{{ $visitPurposesId }}">{{ $visitPurposesValue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select id="filter_stayCategories" class="form-select select2"
                            wire:model="filter_stayCategories">
                            <option value="">Select Stay Category</option>
                            @foreach ($stayCategories as $stayCategoriesId => $stayCategoriesValue)
                                <option value="{{ $stayCategoriesId }}">{{ $stayCategoriesValue }}</option>
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
                            <th>Title</th>
                            <th>Park</th>
                            <th>Date</th>
                            <th>Price (Min-Max)</th>
                            <th>Seats</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shareSafaries as $index => $shareSafari)
                            <tr>
                                <td>{{ $shareSafaries->total() - ($shareSafaries->firstItem() + $index) + 1 }}</td>
                                <td>{{ $shareSafari->title }}</td>
                                <td>{{ $shareSafari->park->title ?? '-' }}</td>
                                <td>{{ $shareSafari->start_date }} → {{ $shareSafari->end_date }}</td>
                                <td>₹{{ $shareSafari->min_price_pp }} - ₹{{ $shareSafari->max_price_pp }}</td>
                                <td>{{ $shareSafari->total_seats }}
                                    (Shared - {{ $shareSafari->share_seats }})
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        wire:click="edit({{ $shareSafari->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger"
                                        wire:click="confirmDelete({{ $shareSafari->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $shareSafaries->links() }}

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
                                @if ($step === 1)
                                    @include('livewire.admin.share-safari-steps.safari-step-1')
                                @elseif ($step === 2)
                                    @include('livewire.admin.share-safari-steps.safari-step-2')
                                @elseif ($step === 3)
                                    @include('livewire.admin.share-safari-steps.safari-step-3')
                                @endif

                                <div class="d-flex justify-content-between mt-3">
                                    @if ($step > 1)
                                        <button type="button" wire:click="previousStep"
                                            class="btn btn-secondary">Back</button>
                                    @endif

                                    @if ($step < 3)
                                        <button type="button" wire:click="nextStep"
                                            class="btn btn-primary ms-auto">Next <i
                                                class="spinner-border spinner-border-sm" wire:loading></i></button>
                                    @else
                                        <button type="submit" class="btn btn-success">
                                            {{ $isEditing ? 'Update' : 'Save' }}
                                            <i class="spinner-border spinner-border-sm" wire:loading></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
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
@script
    <script>
        window.safariNumber = function(e) {
            $('#safariNumber').text($(e).val());
        }
        window.minPricePPChange = function(e) {
            const minPricePPprice = $(e).val();
            $('#max_price_pp').attr('min', minPricePPprice).val(minPricePPprice);
        }
        window.totalSeatsChange = function(e) {
            const totalSeatsCount = $(e).val();
            let arrshareSeatsOption = '<option value="">Select</option>';
            for (let i = 1; i < totalSeatsCount; i++) {
                arrshareSeatsOption += `<option value="${i}">${i}</option>`;
            }
            $('#share_seats').html(arrshareSeatsOption);
        }
    </script>
@endscript
