<div class="modal" id="partitionShowButton{{ $transaction->partition_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="d-inline">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ $transaction->partition->p_number }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="d-block mb-2"><strong>Status:</strong>
                        @if ($transaction->partition->status == 'available')
                            <span class="text-success">Available</span>
                        @elseif ($transaction->partition->status == 'occupied')
                            <span class="text-warning">Occupied</span>
                        @elseif ($transaction->partition->status == 'notice')
                            <span class="text-danger">On Notice</span>
                        @endif
                    </span>
                    <span class="d-block mb-2"><strong>Flat:</strong> {{ $transaction->partition->flat->flat_no }}</span>
                    <span class="d-block mb-2"><strong>Floor:</strong> {{ $transaction->partition->floor->name }}</span>
                    <span class="d-block"><strong>Building:</strong> {{ $transaction->partition->building->name }}</span>
                </div>
            </form>
        </div>
    </div>
</div>
