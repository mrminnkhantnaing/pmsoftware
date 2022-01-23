@extends('layouts.app')

@section('title')
    Add New Referrer | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('referrers.index') }}">REFERRERS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">ADD NEW</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('referrers.index') }}">BACK</a>
        </div>
    </div>

    {{-- Referrer --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Store Referrer Details --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('referrers.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0 d-inline">Full Name</h6> <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" value="{{ old('name') }}" placeholder="Eg. Frank William" />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">ID/Passport</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('idorpassport') border border-danger @enderror" name="idorpassport" value="{{ old('idorpassport') }}" placeholder="Eg. ME123456" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">WhatsApp No.</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('whatsapp_no') border border-danger @enderror" name="whatsapp_no" value="{{ old('whatsapp_no') }}" placeholder="Eg. +97112345678" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Phone No. </h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="number" class="form-control @error('phone_no') border border-danger @enderror" name="phone_no" value="{{ old('phone_no') }}" placeholder="Eg. +97112345678" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Email </h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="email" class="form-control @error('email') border border-danger @enderror" name="email" value="{{ old('email') }}" placeholder="Eg. frankwilliam@gmail.com" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Gender</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <select class="form-select @error('gender') border border-danger @enderror" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Country</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <select class="form-select @error('country_id') border border-danger @enderror" name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10 text-secondary">
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
