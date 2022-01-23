@extends('layouts.app')

@section('title')
    Add New Flat | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('flats.index') }}">FLATS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">ADD NEW</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('flats.index') }}">BACK</a>
        </div>
    </div>

    {{-- Flat --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Store Flat Details --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('flats.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Flat No.</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('flat_no') border border-danger @enderror" name="flat_no" value="{{ old('flat_no') }}" placeholder="Eg. 505" />
                                    @error('flat_no')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Select Building</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <select class="form-select @error('building_id') border border-danger @enderror" name="building_id">
                                        <option value="">Select A Building</option>
                                        @foreach ($buildings as $building)
                                            <option value="{{ $building->id }}">{{ $building->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('building_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Select Floor</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <select class="form-select @error('floor_id') border border-danger @enderror" name="floor_id">
                                        <option value="">Select A Floor</option>
                                    </select>
                                    @error('floor_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
    @include('inc.coms.selects.select-floors-from-building');
@endsection
