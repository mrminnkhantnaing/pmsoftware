@extends('layouts.app')

@section('title')
    Edit {{ $referrer->name }} | {{ config('app.name', 'PM Software') }}
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
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">EDIT {{ $referrer->name }}</li>
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
                        <form action="{{ route('referrers.update', $referrer->id) }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" value="{{ $referrer->name }}" placeholder="Eg. Frank William" />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">ID / Passport</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('idorpassport') border border-danger @enderror" name="idorpassport" value="{{ $referrer->idorpassport }}" placeholder="Eg. ME123456" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">WhatsApp No.</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('whatsapp_no') border border-danger @enderror" name="whatsapp_no" value="{{ $referrer->whatsapp_no }}" placeholder="Eg. +97112345678" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0 d-inline">Phone No. </h6>(Optional)
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('phone_no') border border-danger @enderror" name="phone_no" value="{{ $referrer->phone_no }}" placeholder="Eg. +97112345678" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0 d-inline">Email </h6>(Optional)
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="email" class="form-control @error('email') border border-danger @enderror" name="email" value="{{ $referrer->email }}" placeholder="Eg. frankwilliam@gmail.com" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Gender</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <select class="form-select @error('gender') border border-danger @enderror" name="gender">
                                        <option value="{{ $referrer->gender ? $referrer->gender : '' }}">{{ $referrer->gender ? ucfirst($referrer->gender) : 'Select Gender' }}</option>
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
                                        <option value="{{ $referrer->country_id ? $referrer->country_id : ''}}">{{ $referrer->country_id ? $referrer->country->name : 'Select A Country' }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" value="Update" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
