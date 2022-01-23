@extends('layouts.app')

@section('title')
    Add New Invoice | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
	<link href="{{ asset('assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
@endsection

@section('content')
    {{-- Add Tenant Modal --}}
    <div class="modal" id="addTenant" tabindex="-1" aria-hidden="true">
        <form class="d-inline" action="{{ route('tenants.create') }}" method="GET" target="_blank">
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
                    <li class="breadcrumb-item active" aria-current="page">ADD NEW</li>
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
                        <form class="row g-3" action="{{ route('invoices.store') }}" method="POST">
                            @csrf

                            {{-- 1st Row --}}
                            <div class="col-md-4">
                                <label for="disabled_invoice_no" class="form-label">Invoice No.</label>
                                <input disabled type="text" class="form-control" name="disabled_invoice_no" id="disabled_invoice_no" value="{{ $lastInvoice ? $settings->invoice_prefix . $lastInvoice->invoice_no + 1 : 'AA10000001' }}">
                                <input type="hidden" name="invoice_no" value="{{ $lastInvoice ? $lastInvoice->invoice_no + 1 : 1000000001 }}">
                                <input type="hidden" name="invoice_prefix" value="{{ $settings->invoice_prefix }}">
                            </div>
                            <div class="col-md-4">
                                <label for="idorpassport" class="form-label">ID/Passport</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('tenant_id') border border-danger @enderror" name="idorpassport" value="{{ old('idorpassport') }}" id="idorpassport" placeholder="Eg. ME123456">
                                    <span id="check_idorpassport" class="input-group-text cursor-pointer" title="Check or Activate">
                                        <i class='bx bx-check'></i>
                                    </span>
                                </div>
                                <input type="hidden" name="tenant_id" value="{{ old('tenant_id') }}" />
                                <input type="hidden" name="tenants_fixed_deposit" value="{{ old('tenants_fixed_deposit') }}" />
                                <input type="hidden" name="tenants_previous_balance" value="{{ old('tenants_previous_balance') }}" />
                                @error('tenant_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="name" class="form-label">Full Name</label>
                                <input disabled type="text" class="form-control @error('tenant_id') border border-danger @enderror" name="name" id="name" placeholder="Eg. Frank William">
                                @error('tenant_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- 2nd Row --}}
                            <div class="col-md-4">
                                <label for="building_id" class="form-label">Building</label>
                                <select class="form-select @error('building_id') border border-danger @enderror" name="building_id">
                                    <option value="{{ old('building_id') ?? old('building_id') }}">
                                        @php
                                            $building = DB::table('buildings')->where('id', old('building_id'))->first();
                                            if (old('building_id')) {
                                                echo $building->name;
                                            } else {
                                                echo 'Select A Building';
                                            }
                                        @endphp
                                    </option>
                                    @foreach ($buildings as $building)
                                        <option value="{{ $building->id }}">{{ $building->name }}</option>
                                    @endforeach
                                </select>
                                @error('building_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="floor_id" class="form-label">Floor</label>
                                <select class="form-select @error('floor_id') border border-danger @enderror" name="floor_id">
                                    <option value="{{ old('floor_id') ?? old('floor_id') }}">
                                        @php
                                            $floor = DB::table('floors')->where('id', old('floor_id'))->first();
                                            if (old('floor_id')) {
                                                echo $floor->name;
                                            } else {
                                                echo 'Select A Floor';
                                            }
                                        @endphp
                                    </option>
                                </select>
                                @error('floor_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="flat_id" class="form-label">Flat</label>
                                <select class="form-select @error('flat_id') border border-danger @enderror" name="flat_id">
                                    <option value="{{ old('flat_id') ?? old('flat_id') }}">
                                        @php
                                            $flat = DB::table('flats')->where('id', old('flat_id'))->first();
                                            if (old('flat_id')) {
                                                echo $flat->flat_no;
                                            } else {
                                                echo 'Select A Flat';
                                            }
                                        @endphp
                                    </option>
                                </select>
                                @error('flat_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- 3rd Row --}}
                            <div class="col-md-4">
                                <label for="partition_id" class="form-label">Partition</label>
                                <select class="form-select @error('partition_id') border border-danger @enderror" name="partition_id">
                                    <option value="{{ old('partition_id') ?? old('partition_id') }}">
                                        @php
                                            $partition = DB::table('partitions')->where('id', old('partition_id'))->first();
                                            if (old('partition_id')) {
                                                echo $partition->p_number;
                                            } else {
                                                echo 'Select A Partition';
                                            }
                                        @endphp
                                    </option>
                                </select>
                                @error('partition_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="no_of_tenant" class="form-label">No. of Tenant</label>
                                <input type="number" class="form-control @error('no_of_tenant') border border-danger @enderror" name="no_of_tenant" id="no_of_tenant" placeholder="Eg. 1" min="1" value="{{ old('no_of_tenant') }}">
                                @error('no_of_tenant')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="price" class="form-label">Price ({{ $settings->currency }})</label>
                                <div class="input-group">
                                    <input type="number" min="0" class="form-control @error('price') border border-danger @enderror" name="price" id="price" value="{{ old('price') }}" placeholder="Eg. 600">
                                    <span id="check_or_activate_price" class="input-group-text cursor-pointer" title="Clear Card"><i class='bx bx-check' ></i></span>
                                </div>
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- 4th Row --}}
                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
								<input type="text" class="form-control datepicker @error('start_date') border border-danger @enderror" name="start_date" id="start_date" placeholder="Pick Starting Date" value="{{ old('start_date') }}" />
                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">End Date</label>
								<input type="text" class="form-control datepicker @error('end_date') border border-danger @enderror" name="end_date" id="end_date" placeholder="Pick Ending Date" value="{{ old('end_date') }}" />
                                @error('end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="sub_total" class="form-label">Sub Total ({{ $settings->currency }})</label>
                                <input disabled type="number" class="form-control" name="sub_total" value="{{ old('sub_total') }}" id="sub_total">
                                <input type="hidden" name="sub_total">
                            </div>

                            {{-- 5th Row --}}
                            <div class="col-md-3">
                                <label for="referrer_id" class="form-label">Referrer (Optional)</label>
                                <select class="form-select @error('referrer_id') border border-danger @enderror" name="referrer_id">
                                    <option value="">Select Referrer</option>
                                    @foreach ($referrers as $referrer)
                                        <option value="{{ $referrer->id }}">{{ $referrer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="code">Card ID (Optional)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Eg. 10000001" />
                                    <span id="clear_card" class="input-group-text cursor-pointer" title="Clear Card"><i class='bx bx-trash-alt' ></i></span>
                                </div>

                                <input type="hidden" name="card_id" />
                                <input type="hidden" name="card_price" value="{{ $settings->card_price }}">
                                <input type="hidden" name="currency" value="{{ $settings->currency }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="status">Card Status</label>
								<input disabled type="text" class="form-control" id="status" name="status" placeholder="Eg. Available ({{ $settings->card_price }} {{ $settings->currency }})" />
                            </div>
                            <div class="col-md-3">
                                <label for="grand_total" class="form-label">Grand Total ({{ $settings->currency }})</label>
                                <input type="hidden" name="grand_total" id="grand_total">
                                <input disabled type="number" class="form-control" name="grand_total" value="{{ old('grand_total') ?? old('grand_total') }}" id="grand_total">
                            </div>

                            {{-- 6th Row --}}
                            <div class="col-md-3">
                                <label class="form-label" for="invoice_type">Invoice Type</label>
								<select name="invoice_type" id="invoice_type" class="form-select">

                                    <option value="payment" {{ old('invoice_type') == 'payment' ? 'selected' : '' }}>Payment</option>
                                    <option value="reservation" {{ old('invoice_type') == 'reservation' ? 'selected' : '' }}>Reservation</option>
                                </select>
                                @error('invoice_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="invoice_type_reservation col-md-3 d-none">
                                <label for="deposit" class="form-label">Deposit ({{ $settings->currency }}) <small class="text-danger">*</small></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('deposit') border border-danger @enderror" name="deposit" id="deposit" value="{{ old('deposit') }}" placeholder="Eg. 100">
                                    <span id="check_deposit" class="input-group-text cursor-pointer" title="Check or Calculate">
                                        <i class='bx bx-check'></i>
                                    </span>
                                </div>
                                @error('deposit')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="invoice_type_reservation col-md-3 d-none">
                                <label class="form-label">Reservation Date <small class="text-danger">*</small></label>
								<input type="text" class="form-control datepicker @error('reservation_date') border border-danger @enderror" name="reservation_date" placeholder="Pick Reservation Date" value="{{ old('reservation_date') }}" />
                                @error('reservation_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="invoice_type_payment col-md-3">
                                <label for="payment_amount" class="form-label">Payment Amount ({{ $settings->currency }}) <small class="text-danger">*</small></label>
                                <div class="input-group">
                                    <input type="number" min="0" class="form-control @error('payment_amount') border border-danger @enderror" name="payment_amount" id="payment_amount" value="{{ old('payment_amount') }}" placeholder="Eg. 100">
                                    <span id="check_payment_amount" class="input-group-text cursor-pointer" title="Check or Calculate">
                                        <i class='bx bx-check'></i>
                                    </span>
                                </div>
                                @error('payment_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="invoice_type_payment col-md-3">
                                <label class="form-label">Rest Payment Date <span id="rest_payment_date_option">(Optional)</span></label>
								<input type="text" class="form-control datepicker @error('rest_payment_date') border border-danger @enderror" name="rest_payment_date" placeholder="Pick Rest Payment Date" value="{{ old('rest_payment_date') }}" />
                            </div>

                            <div class="col-md-3">
                                <label for="balance" class="form-label">Balance ({{ $settings->currency }})</label>
                                <input disabled type="number" class="form-control" name="balance" value="{{ old('balance') }}" id="balance">
                            </div>

                            <div class="col-12 ms-auto">
                                <button type="submit" class="btn btn-primary px-5">Save Invoice</button>
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
@endsection
