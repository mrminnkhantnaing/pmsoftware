@extends('layouts.app')

@section('title')
    Edit {{ $building->name }} | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('buildings.index') }}">BUILDINGS</a>
                    </li>
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">EDIT {{ $building->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('buildings.index') }}">BACK</a>
        </div>
    </div>

    {{-- Building --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Update Building Details --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('buildings.update', $building->slug) }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" value="{{ $building->name }}" placeholder="Eg. Building One" />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Location</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('location') border border-danger @enderror" name="location" value="{{ $building->location }}" placeholder="Eg. Day To Day" />
                                    @error('location')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('full_address') border border-danger @enderror" name="full_address" value="{{ $building->full_address }}" placeholder="Eg. Deira, Al Rigga, Dubai" />
                                    @error('full_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" value="Update Building" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
