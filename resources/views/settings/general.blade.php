@extends('layouts.app')

@section('title')
    General Settings | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('settings.general') }}">SETTINGS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">GENERAL</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="">SAVE</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-4">General Settings</h5>
            <form action="{{ route('settings.updateGeneral') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <small class="text-primary">Notice - details of the company are updated in the invoice.</small>
                <div class="row mb-3 mt-3">
                    <div class="col-sm-2">
                        <h6>Company Name</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input type="text" class="form-control @error('company_name') border border-danger @enderror" name="company_name" value="{{ $settings->company_name }}" placeholder="Eg. The Khant Digital" />
                        @error('company_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">
                        <h6>Company Phone No.</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input type="text" class="form-control @error('company_phone_no') border border-danger @enderror" name="company_phone_no" value="{{ $settings->company_phone_no }}" placeholder="Eg. +959123456789" />
                        @error('company_phone_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">
                        <h6>Company Email</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input type="text" class="form-control @error('company_email') border border-danger @enderror" name="company_email" value="{{ $settings->company_email }}" placeholder="Eg. info@thekhantdigital.com" />
                        @error('company_email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">
                        <h6>Company Address</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input type="text" class="form-control @error('company_address') border border-danger @enderror" name="company_address" value="{{ $settings->company_address }}" placeholder="Eg. 27 Kyant Khaing Yay, Thanlyin, Yangon" />
                        @error('company_address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">
                        <h6>Company Logo</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input type="file" class="form-control @error('company_logo') border border-danger @enderror" name="company_logo" />
                        @error('company_logo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2 mt-3"></div>
                    <div class="col-sm-10">
                        <img src="{{ $settings->company_logo ? asset('storage/images/invoice_logos/' . $settings->company_logo) : asset('storage/images/invoice_logos/tkd_logo_element.png') }}" alt="{{ $settings->company_name }}" width="80">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-10 text-secondary">
                        <input type="submit" class="btn btn-primary px-4" value="Update" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
