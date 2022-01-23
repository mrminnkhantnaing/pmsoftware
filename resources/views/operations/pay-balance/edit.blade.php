@extends('layouts.app')

@section('title')
    Edit Pay Balance | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

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
                        <a class="text-dark" href="{{ route('invoices.balance.index') }}">PAY BALANCE</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">EDIT PAY BALANCE FOR {{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('invoices.balance.index') }}">BACK</a>
        </div>
    </div>

    {{-- PAY BALANCE --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Store PAY BALANCE Details --}}
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('invoices.balance.update', $paybalance->id) }}" method="POST">
                            @csrf

                            {{-- 1st Row --}}
                            <div class="col-md-3">
                                <label for="invoice_no" class="form-label">Created At</label>
                                <div class="input-group">
                                    <input disabled type="text" class="form-control" name="invoice_no" id="invoice_no" value="{{ date('d M, Y', strtotime($paybalance->created_at)) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="invoice_no" class="form-label">Invoice No.</label>
                                <div class="input-group">
                                    <input disabled type="text" class="form-control" name="invoice_no" id="invoice_no" value="{{ $transaction->invoice_prefix . $transaction->invoice_no }}">
                                    <input type="hidden" name="invoice_id" value="{{ $transaction->id }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="idorpassport" class="form-label">ID/Passport</label>
                                <input disabled type="text" class="form-control" name="idorpassport" value="{{ $paybalance->tenant->idorpassport }}" id="idorpassport">
                            </div>
                            <div class="col-md-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input disabled type="text" class="form-control" name="name" value="{{ $paybalance->tenant->name }}" id="name">
                            </div>

                            {{-- 2nd Row --}}
                            <div class="col-md-4">
                                <label for="building_id" class="form-label">Building</label>
                                <input disabled type="text" class="form-control" value="{{ $paybalance->building->name }}" name="building_id" id="building_id">
                                <input type="hidden" class="form-control" name="ibuilding_id" value="{{ $paybalance->building_id }}">
                            </div>
                            <div class="col-md-4">
                                <label for="floor_id" class="form-label">Floor</label>
                                <input disabled type="text" class="form-control" value="{{ $paybalance->floor->name }}" name="floor_id" id="floor_id">
                                <input type="hidden" class="form-control" name="ifloor_id" value="{{ $paybalance->floor_id }}">
                            </div>
                            <div class="col-md-4">
                                <label for="flat_id" class="form-label">Flat</label>
                                <input disabled type="text" class="form-control" value="{{ $paybalance->flat->flat_no }}" name="flat_id" id="flat_id">
                                <input type="hidden" class="form-control" name="iflat_id" value="{{ $paybalance->flat_id }}">
                            </div>

                            {{-- 3rd Row --}}
                            <div class="col-md-4">
                                <label for="partition_id" class="form-label">Partition</label>
                                <input disabled type="text" class="form-control" value="{{ $paybalance->partition->p_number }}" name="partition_id" id="partition_id">
                                <input type="hidden" class="form-control" name="ipartition_id" value="{{ $paybalance->partition_id }}">
                            </div>
                            <div class="col-md-4">
                                <label for="no_of_tenant" class="form-label">No. of Tenant</label>
                                <input type="number" class="form-control" name="no_of_tenant" id="no_of_tenant" placeholder="Eg. 1" min="1" value="{{ $paybalance->no_of_tenant }}">
                                <input type="hidden" class="form-control" name="tenant_id" value="{{ $paybalance->tenant_id }}">
                                @error('no_of_tenant')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="price" class="form-label">Price ({{ $paybalance->currency }})</label>
                                <input type="number" min="0" class="form-control @error('price') border border-danger @enderror" name="price" id="price" value="{{ $paybalance->price }}" placeholder="Eg. 600">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- 4th Row --}}
                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
								<input type="text" class="form-control datepicker @error('start_date') border border-danger @enderror" name="start_date" id="start_date" placeholder="Pick Starting Date" value="{{ date('j F, Y', strtotime($paybalance->start_date)) }}" />
                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">End Date</label>
								<input type="text" class="form-control datepicker @error('end_date') border border-danger @enderror" name="end_date" id="end_date" placeholder="Pick Ending Date" value="{{ date('j F, Y', strtotime($paybalance->end_date)) }}" />
                                @error('end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="sub_total" class="form-label">Sub Total ({{ $paybalance->currency }})</label>
                                <input disabled type="number" class="form-control" name="sub_total" value="{{ $paybalance->sub_total }}" id="sub_total">
                                <input type="hidden" name="sub_total" value="{{ $paybalance->sub_total }}">
                            </div>

                            {{-- 5th Row --}}
                            <div class="col-md-3">
                                <label for="referrer_id" class="form-label">Referrer</label>
                                <input disabled type="text" class="form-control" value="{{ $paybalance->referrer_id ? $paybalance->referrer->name : '' }}" name="referrer_id" id="referrer_id">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="code">Card ID (Optional)</label>
                                <div class="input-group">
                                    <input disabled type="text" class="form-control" id="code" value="{{ $paybalance->card_id ? $paybalance->card->code : '' }}" name="code" placeholder="Eg. 10000001" />
                                    {{-- <span id="clear_card" class="input-group-text cursor-pointer" title="Clear Card"><i class='bx bx-trash-alt' ></i></span> --}}
                                </div>

                                <input type="hidden" name="card_id" value="{{ $paybalance->card_id ? $paybalance->card_id : '' }}" />
                                <input type="hidden" name="card_price" value="{{ $settings->card_price }}">
                                <input type="hidden" name="currency" value="{{ $settings->currency }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="status">Card Status</label>
                                @php
                                    if ($paybalance->card_id) {
                                        $card_id_status = ucfirst($paybalance->card->status) . ' ('. $paybalance->card_price .' '. $paybalance->currency .')';
                                    } else {
                                        $card_id_status = 'Eg. Available ('. $paybalance->card_price .' '. $paybalance->currency .')';
                                    }
                                @endphp
								<input disabled type="text" class="form-control" id="status" value="{{ $card_id_status }}" name="status" placeholder="Eg. Available ({{ $settings->card_price }} {{ $settings->currency }})" />
                            </div>
                            <div class="col-md-3">
                                <label for="grand_total" class="form-label">Grand Total ({{ $paybalance->currency }})</label>
                                <input disabled type="number" class="form-control" name="grand_total" value="{{ $paybalance->total_price }}">
                                <input type="hidden" name="grand_total" id="grand_total" value="{{ $paybalance->total_price }}">
                            </div>

                            {{-- 6th Row --}}
                            <div class="col-md-3">
                                <label class="form-label" for="invoice_type">Invoice Type</label>
								<input disabled type="text" class="form-control" value="{{ ucfirst($paybalance->invoice_type) }}" name="invoice_type" id="invoice_type">
                                <input type="hidden" name="invoice_type" value="{{ $paybalance->invoice_type }}">
                            </div>

                            <div class="invoice_type_payment col-md-3">
                                <label for="initial_payment_amount" class="form-label">Initial Paid Amount ({{ $settings->currency }})</label>
                                <div class="input-group">
                                    <input disabled type="text" class="form-control" name="initial_payment_amount" id="initial_payment_amount" value="{{ $paybalance->initial_payment_amount }}">
                                    <input type="hidden" name="initial_payment_amount" value="{{ $paybalance->initial_payment_amount }}">
                                    <span id="calculate_balance_from_initial_payment" class="input-group-text cursor-pointer" title="Check or Calculate">
                                        <i class='bx bx-check'></i>
                                    </span>
                                </div>
                            </div>
                            <div class="invoice_type_payment col-md-3">
                                <label for="current_payment_amount" class="form-label">Current Paid Amount ({{ $settings->currency }})</label>
                                <div class="input-group">
                                    <input type="number" min="0" class="form-control @error('current_payment_amount') border border-danger @enderror" name="current_payment_amount" id="current_payment_amount" value="{{ $paybalance->current_payment_amount }}" placeholder="Eg. 100">
                                    <span id="calculate_balance_from_current_payment" class="input-group-text cursor-pointer" title="Check or Calculate">
                                        <i class='bx bx-check'></i>
                                    </span>
                                    @error('current_payment_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="balance" class="form-label">Balance ({{ $settings->currency }})</label>
                                <input disabled type="number" class="form-control" name="balance" value="{{ $paybalance->balance }}" id="balance">
                                <input type="hidden" name="balance" value="{{ $paybalance->balance }}">
                                @error('balance')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 ms-auto">
                                <button type="submit" class="btn btn-primary px-5">Update PayBalance</button>
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
    @include('inc.coms.selects.select-invoice-from-invoice-number')

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
