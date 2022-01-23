@extends('layouts.app')

@section('title')
    Card Receipts | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
@endsection

@section('content')
    {{-- Breadcrumb --}}
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('dashboard') }}">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('invoices.cards.index') }}">CARD RECEIPT</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">CARD RECEIPTS ({{ $cardReceipts->count() }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a class="btn btn-primary" href="{{ route('invoices.cards.create') }}">ADD NEW</a>
                <a class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <form action="{{ route('invoices.cards.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="days" value="0">
                        <button type="submit" class="dropdown-item text-uppercase">Export For Today</button>
                    </form>
                    <form action="{{ route('invoices.cards.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="days" value="1">
                        <button type="submit" class="dropdown-item text-uppercase">EXPORT For Yesterday</button>
                    </form>
                    <form action="{{ route('invoices.cards.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="days" value="7">
                        <button type="submit" class="dropdown-item text-uppercase">EXPORT LAST 7 Days</button>
                    </form>
                    <form action="{{ route('invoices.cards.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="days" value="15">
                        <button type="submit" class="dropdown-item text-uppercase">EXPORT LAST 15 days</button>
                    </form>
                    <form action="{{ route('invoices.cards.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="days" value="30">
                        <button type="submit" class="dropdown-item text-uppercase">EXPORT LAST 30 days</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Receipts --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Created At</th>
                            <th>Card ID</th>
                            <th>Tenant Name</th>
                            <th>ID/Passport</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Issued Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cardReceipts as $cardReceipt)
                            <tr>
                                <td>{{ date('d M, Y', strtotime($cardReceipt->created_at)) }}</td>
                                <td>{{ $cardReceipt->card->code }}</td>
                                <td><a class="text-dark" title="View" href="{{ route('tenants.show', $cardReceipt->tenant_id) }}">{{ $cardReceipt->tenant->name }}</a></td>
                                <td>
                                    <a class="text-dark" title="View" href="{{ route('tenants.show', $cardReceipt->tenant_id) }}">{{ $cardReceipt->tenant->idorpassport }}</a>
                                </td>
                                <td>{{ $cardReceipt->card_price }} {{ $cardReceipt->currency }}</td>
                                <td>0 {{ $cardReceipt->currency }}</td>
                                <td>
                                    @if($cardReceipt->receipt_status == 'issued')
                                        <span class="text-warning">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                    @elseif ($cardReceipt->receipt_status == 'returned')
                                        <span class="text-success">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                    @else
                                        <span class="text-danger">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                    @endif
                                </td>
                                <td>{{ date('d M, Y', strtotime($cardReceipt->issued_date)) }}</td>

                                <td>
                                    {{-- Button View Modal --}}
                                    <button type="button" class="btn btn-outline-dark" title="View" data-bs-toggle="modal" data-bs-target="#cardReceiptViewButton{{ $cardReceipt->id }}">
                                        <i class='bx bx-show me-0'></i>
                                    </button>
                                    {{-- View Modal --}}
                                    <div class="modal fade" id="cardReceiptViewButton{{ $cardReceipt->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Card Receipt</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="d-inline" action="{{ route('invoices.cards.show', $cardReceipt->id) }}" method="POST">
                                                        @csrf
                                                        <p><strong>Tenant:</strong> {{ $cardReceipt->tenant->name }} ({{ $cardReceipt->tenant->idorpassport }})</p>
                                                        <p><strong>Card ID:</strong> {{ $cardReceipt->card->code }}</p>
                                                        <p><strong>Card Price:</strong> {{ $cardReceipt->card_price }} {{ $cardReceipt->currency }}</p>
                                                        <p><strong>Receipt Status:</strong>
                                                            @if($cardReceipt->receipt_status == 'issued')
                                                                <span class="text-warning">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                            @elseif ($cardReceipt->receipt_status == 'returned')
                                                                <span class="text-success">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                            @else
                                                                <span class="text-danger">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                            @endif
                                                        </p>
                                                        <p><strong>Created At:</strong> {{ date('d M, Y', strtotime($cardReceipt->created_at)) }}</p>
                                                        <p><strong>Issued Date:</strong> {{ date('d M, Y', strtotime($cardReceipt->issued_date)) }}</p>
                                                        @if ($cardReceipt->returned_date)
                                                            <p><strong>Returned Date:</strong> {{ date('d M, Y', strtotime($cardReceipt->returned_date)) }}</p>
                                                        @endif
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    {{-- Download Receipt --}}
                                                    <a target="_blank" href="{{ route('invoices.cards.print', $cardReceipt->id) }}" class="btn btn-primary">Print Or Download</a>
                                                    {{-- Send Receipt --}}
                                                    {{-- <form action="{{ route('sendReceipt', $cardReceipt->id) }}" method="POST">
                                                        @csrf
                                                        <button class="btn btn-outline-primary text-uppercase" type="submit">SEND EMAIL TO {{ $cardReceipt->tenant->name }}</button>
                                                    </form> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @can('edit cardreceipts')
                                        {{-- Button Edit Modal --}}
                                        <button type="button" class="btn btn-outline-primary"  title="Edit" data-bs-toggle="modal" data-bs-target="#cardReceiptEditButton{{ $cardReceipt->id }}">
                                            <i class='bx bx-edit-alt me-0'></i>
                                        </button>
                                        {{-- Edit Modal --}}
                                        <div class="modal" id="cardReceiptEditButton{{ $cardReceipt->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form class="d-inline" action="{{ route('invoices.cards.update', $cardReceipt->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Card Receipt</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="idorpassport" class="form-label">Passport No.</label>
                                                                    <input disabled type="text" class="form-control @error('tenant_id') border border-danger @enderror" name="idorpassport" value="{{ $cardReceipt->tenant->idorpassport }}" id="idorpassport" placeholder="Eg. ME123456">
                                                                    <input type="hidden" name="tenant_id" value="{{ $cardReceipt->tenant_id }}" />
                                                                    @error('tenant_id')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="name" class="form-label">Full Name</label>
                                                                    <input disabled type="text" class="form-control @error('tenant_id') border border-danger @enderror" value="{{ $cardReceipt->tenant->name }}" name="name" id="name" placeholder="Eg. Frank William">
                                                                    @error('tenant_id')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label" for="code">Card ID</label>
                                                                    <input disabled type="text" class="form-control" id="code" name="code" placeholder="Eg. 10000001" value="{{  $cardReceipt->card->code }}" />
                                                                    @error('card_id')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror

                                                                    <input type="hidden" name="card_id" value="{{ $cardReceipt->card_id }}" />
                                                                    <input type="hidden" name="card_price" value="{{ $cardReceipt->card_price }}">
                                                                    <input type="hidden" name="currency" value="{{ $cardReceipt->currency }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Issued Date</label>
                                                                    <input disabled type="text" class="form-control @error('issued_date') border border-danger @enderror" name="issued_date" placeholder="Pick Issued Date" value="{{ date('d M, Y', strtotime($cardReceipt->issued_date)) }}" />
                                                                    @error('issued_date')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label" for="status">Receipt Status</label>
                                                                    <select class="form-select @error('receipt_status') border border-danger @enderror" name="receipt_status">
                                                                        <option value="{{ $cardReceipt->receipt_status }}">{{ ucfirst($cardReceipt->receipt_status) }} (Current)</option>
                                                                        <option value="issued">Issued</option>
                                                                        <option value="returned">Returned</option>
                                                                        <option value="lost">Lost</option>
                                                                    </select>
                                                                    @error('receipt_status')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Returned Date</label>
                                                                    <input type="text" class="form-control datepicker" name="returned_date" placeholder="Pick Returned Date" value="{{ $cardReceipt->returned_date ? date('d M, Y', strtotime($cardReceipt->issued_date)) : '' }}" />
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button class="btn btn-primary" type="submit">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan

                                    @can('delete cardreceipts')
                                        {{-- Button Delete Modal --}}
                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#cardReceiptDeleteButton{{ $cardReceipt->id }}">
                                            <i class='bx bx-trash me-0'></i>
                                        </button>
                                        {{-- Modal --}}
                                        <div class="modal" id="cardReceiptDeleteButton{{ $cardReceipt->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form class="d-inline" action="{{ route('invoices.cards.destroy', $cardReceipt->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Card Receipt</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span>Are you sure you would like to delete this Card Receipt?</span>
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
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Created At</th>
                            <th>Card ID</th>
                            <th>Tenant Name</th>
                            <th>ID/Passport</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Issued Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>

    @include('inc.coms.selects.select-tenant-from-passport-no');
    @include('inc.coms.selects.select-card-from-code');

	<script src="{{ asset('assets/plugins/datetimepicker/js/legacy.js') }}"></script>
	<script src="{{ asset('assets/plugins/datetimepicker/js/picker.js') }}"></script>
	<script src="{{ asset('assets/plugins/datetimepicker/js/picker.time.js') }}"></script>
	<script src="{{ asset('assets/plugins/datetimepicker/js/picker.date.js') }}"></script>
	<script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js') }}"></script>

    <script>
		$('.datepicker').pickadate({
			selectMonths: true,
	        selectYears: true
		}),
		$('.timepicker').pickatime()
	</script>
	<script>
		$(function () {
			$('#date-time').bootstrapMaterialDatePicker({
				format: 'YYYY-MM-DD HH:mm'
			});
			$('#date').bootstrapMaterialDatePicker({
				time: false
			});
			$('#time').bootstrapMaterialDatePicker({
				date: false,
				format: 'HH:mm'
			});
		});
	</script>
@endsection
