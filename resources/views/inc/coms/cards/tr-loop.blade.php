<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $card->code }}</td>
    <td>
        @if ($card->status === 'available')
            <span class="text-success">Available</span>
        @elseif ($card->status === 'active')
            <span class="text-warning">Active</span>
        @elseif ($card->status == 'lost')
            <span class="text-danger">Lost</span>
        @else
            <span class="text-secondary">Undefined</span>
        @endif
    </td>
    <td class="justify-content-center">
        {{-- Show Card Triger Modal --}}
        <button type="button" class="btn btn-outline-dark" title="View" data-bs-toggle="modal" data-bs-target="#showCard{{ $card->id }}">
            <i class='bx bx-show me-0'></i>
        </button>
        {{-- Show Card Modal --}}
        <div class="modal" id="showCard{{ $card->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Card Details</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mt-2"><strong>Card ID:</strong> {{ $card->code }}</p>
                        <p><strong>Status:</strong>
                            @if ($card->status === 'available')
                            <span class="text-success">Available</span>
                            @elseif ($card->status === 'active')
                            <span class="text-warning">Active</span>
                            @else
                            <span class="text-danger">Lost</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @can('edit cards')
            {{-- Edit Card Triger Modal --}}
            <button type="button" class="btn btn-outline-primary" title="Edit" data-bs-toggle="modal" data-bs-target="#editCard{{ $card->id }}">
                <i class='bx bx-edit-alt me-0'></i>
            </button>
            {{-- Edit Card Modal --}}
            <div class="modal" id="editCard{{ $card->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="d-inline" action="{{ route('cards.update', $card->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h6 class="modal-title">Edit Card ({{ $card->code }})</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Card ID</label>
                                    <input type="number" name="code" class="form-control" value="{{ $card->code }}" placeholder="Eg. 10000001" />
                                </div>
                                <div>
                                    <label class="form-label">Card Status</label>
                                    <select class="form-select" name="status">
                                        <option value="{{ $card->status }}">{{ ucfirst($card->status) }} (Current Value)</option>
                                        <option value="available">Available</option>
                                        <option value="active">Active</option>
                                        <option value="lost">Lost</option>

                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @can('delete cards')
            {{-- Delete Card Triger Modal --}}
            <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#cardDeleteButton{{ $card->id }}">
                <i class='bx bx-trash me-0'></i>
            </button>
            {{-- Delete Card Modal --}}
            <div class="modal" id="cardDeleteButton{{ $card->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form class="d-inline" action="{{ route('cards.destroy', $card->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h6 class="modal-title">Delete Card</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you would like to delete this card (Card ID - {{ $card->code }})?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    </td>
</tr>
