<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ $pageTitle }} Management</h4>
            <button class="btn btn-primary" wire:click="openModal">Add {{ $pageTitle }}</button>
        </div>
        <div class="card-body">
            <div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search {{ $pageTitle }}..."
                    class="form-control mb-3 ms-auto" style="width:250px;">
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Park</th>
                        <th>Date</th>
                        <th>Price (Min-Max)</th>
                        <th>Seats</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shareSafaries as $shareSafari)
                        <tr>
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
