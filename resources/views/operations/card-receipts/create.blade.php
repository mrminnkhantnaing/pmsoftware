@extends('layouts.app')

@section('title')
    Create Card Receipt | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
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
                        <a class="text-dark" href="{{ route('invoices.cards.index') }}">CARD RECEIPT</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">ADD NEW</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('invoices.cards.index') }}">BACK</a>
        </div>
    </div>

    {{-- invoice --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Store invoice Details --}}
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('invoices.cards.store') }}" method="POST">
                            @csrf

                            <div class="col-md-6">
                                <label for="passport_no" class="form-label">Passport No.</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('tenant_id') border border-danger @enderror" name="idorpassport" value="{{ old('idorpassport') }}" id="idorpassport" placeholder="Eg. ME123456">
                                    <span id="check_idorpassport" class="input-group-text cursor-pointer" title="Check or Activate">
                                        <i class='bx bx-check'></i>
                                    </span>
                                </div>
                                <input type="hidden" name="tenant_id" value="{{ old('tenant_id') }}" />
                                @error('tenant_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input disabled type="text" class="form-control @error('tenant_id') border border-danger @enderror" name="name" id="name" placeholder="Eg. Frank William">
                                @error('tenant_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="code">Card ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Eg. 10000001" />
                                    <span id="clear_card" class="input-group-text cursor-pointer" title="Clear Card"><i class='bx bx-trash-alt' ></i></span>
                                </div>
                                @error('card_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <input type="hidden" name="card_id" />
                                <input type="hidden" name="card_price" value="{{ $settings->card_price }}">
                                <input type="hidden" name="currency" value="{{ $settings->currency }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="status">Card Status</label>
								<input disabled type="text" class="form-control" id="status" name="status" placeholder="Eg. Available ({{ $settings->card_price }} {{ $settings->currency }})" />
                                @error('card_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Issued Date</label>
								<input type="text" class="form-control datepicker @error('issued_date') border border-danger @enderror" name="issued_date" placeholder="Pick Issued Date" value="{{ old('issued_date') }}" />
                                @error('issued_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="status">Receipt Status</label>
								<select disabled class="form-select @error('receipt_status') border border-danger @enderror" name="receipt_status">
                                    <option value="">Issued</option>
                                </select>
                                @error('receipt_status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 ms-auto">
                                <button type="submit" class="btn btn-primary px-5">Save Receipt</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
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
