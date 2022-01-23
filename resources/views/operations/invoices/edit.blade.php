@extends('layouts.app')

@section('title')
    Edit Invoice | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

	<link href="{{ asset('assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
@endsection

@section('content')
    {{-- Add Tenant Modal --}}
    <div class="modal" id="addTenant" tabindex="-1" aria-hidden="true">
        <form class="d-inline" action="{{ route('tenants.create') }}" method="GET">
            @csrf
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Add New Tenant</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="text-danger d-block">The tenant with the passport number you entered does not exist!</span><br>
                        <span class="d-block">Click 'Add New' if you would like to create a new tenant.</span>
                        Or click 'Cancel' to stay on current page.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Breadcrumb --}}
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('dashboard') }}">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('invoices.index') }}">INVOICE</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">EDIT {{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('invoices.index') }}">BACK</a>
        </div>
    </div>

    {{-- invoice --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Store invoice Details --}}
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('invoices.update', $transaction->id) }}" method="POST">
                            @csrf

                            <div class="col-md-3">
                                <label for="disabled_invoice_no" class="form-label">Invoice Date</label>
                                <input disabled type="text" class="form-control" name="disabled_invoice_no" id="disabled_invoice_no" value="{{ date('d M, Y', strtotime($transaction->created_at)) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="disabled_invoice_no" class="form-label">Invoice No.</label>
                                <input disabled type="text" class="form-control" name="disabled_invoice_no" id="disabled_invoice_no" value="{{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}">
                                <input type="hidden" name="invoice_no" value="{{ $transaction->invoice_no }}">
                            </div>
                            <div class="col-md-3">
                                <label for="idorpassport" class="form-label">Passport No.</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('tenant_id') border border-danger @enderror" name="idorpassport" value="{{ $transaction->tenant->idorpassport }}" id="idorpassport" placeholder="Eg. ME123456">
                                    <span id="check_idorpassport" class="input-group-text cursor-pointer" title="Check or Activate">
                                        <i class='bx bx-check'></i>
                                    </span>
                                </div>
                                <input type="hidden" name="tenant_id" value="{{ $transaction->tenant_id }}" />
                                <input type="hidden" name="tenants_fixed_deposit" value="{{ $transaction->tenant->fixed_deposit }}" />
                                <input type="hidden" name="tenants_previous_balance" value="{{ $transaction->tenant->fixed_deposit }}" />
                                @error('tenant_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input disabled type="text" class="form-control @error('tenant_id') border border-danger @enderror" name="name" id="name" placeholder="Eg. Frank William" value="{{ $transaction->tenant->name }} {{ $transaction->fixed_deposit ? '(' . $transaction->fixed_deposit . ' ' . $transaction->currency . ')' : '' }}">
                                @error('tenant_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="building_id" class="form-label">Building</label>
                                <select class="form-select @error('building_id') border border-danger @enderror" name="building_id">
                                    @foreach ($buildings as $building)
                                        <option value="{{ $building->id }}" {{ $building->id == $transaction->building_id ? 'selected' : '' }}>{{ $building->name }}</option>
                                    @endforeach
                                </select>
                                @error('building_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="floor_id" class="form-label">Floor</label>
                                <select class="form-select @error('floor_id') border border-danger @enderror" name="floor_id">
                                    @php
                                        $floors = DB::table('floors')->where('building_id', $transaction->building_id)->get();
                                    @endphp
                                    @foreach($floors as $floor)
                                        <option value="{{ $floor->id }}" {{ $floor->id == $transaction->floor_id ? 'selected' : '' }}>
                                            {{ $floor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('floor_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="flat_id" class="form-label">Flat</label>
                                <select class="form-select @error('flat_id') border border-danger @enderror" name="flat_id">
                                    @php
                                        $flats = DB::table('flats')->where('floor_id', $transaction->floor_id)->get();
                                    @endphp
                                    @foreach($flats as $flat)
                                        <option value="{{ $flat->id }}" {{ $flat->id == $transaction->flat_id ? 'selected' : '' }}>
                                            {{ $flat->flat_no }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('flat_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="partition_id" class="form-label">Partition</label>
                                <select class="form-select @error('partition_id') border border-danger @enderror" name="partition_id">
                                    @php
                                        $partitions = DB::table('partitions')->where('flat_id', $transaction->flat_id)->get();
                                    @endphp
                                    @foreach($partitions as $partition)
                                        @if ($partition->id == $transaction->partition_id)
                                            <option value="{{ $partition->id }}" {{ $partition->id == $transaction->partition_id ? 'selected' : '' }}>
                                                {{ $partition->p_number }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('partition_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="no_of_tenant" class="form-label">No. of Tenant</label>
                                <input type="number" class="form-control" name="no_of_tenant" id="no_of_tenant" placeholder="Eg. 1" min="1" value="{{ $transaction->no_of_tenant }}">
                                @error('no_of_tenant')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="price" class="form-label">Price ({{ $transaction->currency }})</label>
                                <input type="number" class="form-control @error('price') border border-danger @enderror" name="price" id="price" value="{{ $transaction->price }}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
								<input type="text" class="form-control datepicker @error('start_date') border border-danger @enderror" name="start_date" placeholder="Pick Starting Date" value="{{ date('j F, Y', strtotime($transaction->start_date)) }}" />
                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">End Date</label>
								<input type="text" class="form-control datepicker @error('end_date') border border-danger @enderror" name="end_date" placeholder="Pick Ending Date" value="{{ date('j F, Y', strtotime($transaction->end_date)) }}" />
                                @error('end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="sub_total" class="form-label">Sub Total ({{ $transaction->currency }})</label>
                                <input disabled type="number" class="form-control" name="sub_total" value="{{ $transaction->sub_total }}" id="sub_total">
                                <input type="hidden" name="sub_total" value="{{ $transaction->sub_total }}">
                                @error('sub_total')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- 5th Row --}}
                            <div class="col-md-3">
                                <label for="referrer_id" class="form-label">Referrer (Optional)</label>
                                <select class="form-select @error('referrer_id') border border-danger @enderror" name="referrer_id">
                                    <option value="{{ $transaction->referrer_id ? $transaction->referrer_id : '' }}">
                                        @if ($transaction->referrer_id)
                                            {{ $transaction->referrer->name }} (Current)
                                        @else
                                            Select A Referrer
                                        @endif
                                    </option>
                                    @foreach ($referrers as $referrer)
                                        <option value="{{ $referrer->id }}">{{ $referrer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="code">Card ID (Optional)</label>
                                @if ($transaction->card_id)
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="code" name="code" value="{{ $transaction->card->code }}" placeholder="Eg. 10000001" />
                                        <span id="clear_card" class="input-group-text cursor-pointer" title="Clear Card"><i class='bx bx-trash-alt' ></i></span>
                                    </div>
                                @else
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="code" name="code" value="" placeholder="Eg. 10000001" />
                                        <span id="clear_card" class="input-group-text cursor-pointer" title="Clear Card"><i class='bx bx-trash-alt' ></i></span>
                                    </div>
                                @endif
                                <input type="hidden" name="card_id" value="{{ $transaction->card_id }}" />
                                <input type="hidden" name="card_price" value="{{ $transaction->card_price }}">
                                <input type="hidden" name="currency" value="{{ $transaction->currency }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="status">Card Status</label>
                                @php
                                    if ($transaction->card_id) {
                                        $card_id_status = ucfirst($transaction->card->status) . ' ('. $transaction->card_price .' '. $transaction->currency .')';
                                    } else {
                                        $card_id_status = 'Eg. Available ('. $transaction->card_price .' '. $transaction->currency .')';
                                    }
                                @endphp
								<input disabled type="text" class="form-control" id="status" value="{{ $card_id_status }}" name="status" />
                            </div>
                            <div class="col-md-3">
                                <label for="grand_total" class="form-label">Grand Total ({{ $transaction->currency }})</label>
                                <input type="number" class="form-control" name="grand_total" value="{{ $transaction->total_price }}" id="grand_total">
                            </div>

                            {{-- 6th Row --}}
                            @if ($transaction->invoice_type == 'payment')
                                <div class="col-md-3">
                                    <label class="form-label" for="invoice_type">Invoice Type</label>
                                    <select disabled name="invoice_type" id="invoice_type" class="form-select">
                                        <option value="payment">Payment</option>
                                    </select>
                                </div>

                                <div class="invoice_type_payment col-md-3">
                                    <label for="payment_amount" class="form-label">Payment Amount ({{ $settings->currency }})</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control @error('payment_amount') border border-danger @enderror" name="payment_amount" id="payment_amount" value="{{ $transaction->payment_amount }}" placeholder="Eg. 100">
                                        <span id="check_payment_amount" class="input-group-text cursor-pointer" title="Check or Calculate">
                                            <i class='bx bx-check'></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="invoice_type_payment col-md-3">
                                    <label class="form-label">Rest Payment Date (Optional)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker @error('rest_payment_date') border border-danger @enderror" name="rest_payment_date" placeholder="Pick Rest Payment Date" value="{{ $transaction->rest_payment_date ? date('j F, Y', strtotime($transaction->rest_payment_date)) : '' }}" />
                                        {{-- <span id="clear_rest_payment_date" class="input-group-text cursor-pointer" title="Clear Rest Payment Date"><i class='bx bx-trash-alt' ></i></span> --}}
                                    </div>
                                </div>
                            @endif

                            @if ($transaction->invoice_type == 'reservation')
                                <div class="col-md-3">
                                    <label class="form-label" for="invoice_type">Invoice Type</label>
                                    <select disabled name="invoice_type" id="invoice_type" class="form-select">
                                        <option value="reservation">Reservation</option>
                                    </select>
                                </div>

                                <div class="invoice_type_reservation col-md-3">
                                    <label for="deposit" class="form-label">Deposit ({{ $settings->currency }})</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('deposit') border border-danger @enderror" name="deposit" id="deposit" value="{{ $transaction->deposit }}" placeholder="Eg. 100">
                                        <span id="check_deposit" class="input-group-text cursor-pointer" title="Check or Calculate">
                                            <i class='bx bx-check'></i>
                                        </span>
                                    </div>
                                    @error('deposit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="invoice_type_reservation col-md-3">
                                    <label class="form-label">Reservation Date</label>
                                    <input type="text" class="form-control datepicker @error('reservation_date') border border-danger @enderror" name="reservation_date" placeholder="Pick Reservation Date" value="{{ date('j F, Y', strtotime($transaction->reservation_date)) }}" />
                                </div>
                            @endif

                            <div class="col-md-3">
                                <label for="balance" class="form-label">Balance ({{ $settings->currency }})</label>
                                <input disabled type="number" class="form-control" name="balance" value="{{ $transaction->balance }}" id="balance">
                            </div>

                            <div class="col-12 ms-auto">
                                <button type="submit" class="btn btn-primary px-5">Update Invoice</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
    @include('inc.coms.selects.select-floors-from-building');
    @include('inc.coms.selects.select-flats-from-floors');
    @include('inc.coms.selects.select-partitions-from-flat');
    @include('inc.coms.selects.select-tenant-from-passport-no');
    @include('inc.coms.selects.select-card-from-code');
    @include('inc.coms.calculations.calculate-sub-price-with-duration');
    @include('inc.coms.selects.select-invoice-type');
    @include('inc.coms.calculations.calculate-balance-from-payment-amount-and-deposit');

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

    {{-- Multiple Select --}}
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    </script>
@endsection
