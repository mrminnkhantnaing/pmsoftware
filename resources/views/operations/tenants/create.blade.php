@extends('layouts.app')

@section('title')
    Add New Tenant | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
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
                        <a class="text-dark" href="{{ route('tenants.index') }}">TENANTS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">ADD NEW</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('tenants.index') }}">BACK</a>
        </div>
    </div>

    {{-- Tenant --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Store Tenant Details --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('tenants.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" value="{{ old('name') }}" placeholder="Eg. Frank William" />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">ID/Passport</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control @error('idorpassport') border border-danger @enderror" name="idorpassport" value="{{ old('idorpassport') }}" placeholder="Eg. ME123456" />
                                    @error('idorpassport')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">WhatsApp No.</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control @error('whatsapp_no') border border-danger @enderror" name="whatsapp_no" value="{{ old('whatsapp_no') }}" placeholder="Eg. +97112345678" />
                                    @error('whatsapp_no')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 d-inline">Phone No. </h6>(Optional)
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control @error('phone_no') border border-danger @enderror" name="phone_no" value="{{ old('phone_no') }}" placeholder="Eg. +97112345678" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 d-inline">Email </h6>(Optional)
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="email" class="form-control @error('email') border border-danger @enderror" name="email" value="{{ old('email') }}" placeholder="Eg. frankwilliam@gmail.com" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 d-inline">Joined Date </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control datepicker @error('joined_date') border border-danger @enderror" name="joined_date" placeholder="Pick Joined Date" value="{{ old('joined_date') }}" />
                                </div>
                                @error('joined_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 d-inline">Fixed Deposit </h6>(Optional)
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control @error('fixed_deposit') border border-danger @enderror" name="fixed_deposit" value="{{ old('fixed_deposit') }}" placeholder="Eg. 500" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 d-inline">Previous Balance </h6>(Optional)
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control @error('previous_balance') border border-danger @enderror" name="previous_balance" value="{{ old('previous_balance') }}" placeholder="Eg. 500" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Gender</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select class="form-select @error('gender') border border-danger @enderror" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    @error('gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Country</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select class="form-select @error('country_id') border border-danger @enderror" name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" value="Add New" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
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
