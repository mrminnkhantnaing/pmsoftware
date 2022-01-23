@extends('layouts.app')

@section('title')
    Edit {{ $partition->name }} | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('partitions.index') }}">PARTITIONS</a>
                    </li>
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">EDIT {{ $partition->p_number }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('partitions.index') }}">BACK</a>
        </div>
    </div>

    {{-- partition --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Store partition Details --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('partitions.update', $partition->id) }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Partition No.</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('p_number') border border-danger @enderror" name="p_number" value="{{ $partition->p_number }}" placeholder="Eg. Partition 01" />
                                    @error('p_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Select Building</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <select class="form-select mb-3 @error('building_id') border border-danger @enderror" name="building_id">
                                        <option disabled>Select A Building</option>
                                        @foreach ($buildings as $building)
                                            <option {{ $partition->building_id === $building->id ? 'selected' : '' }} value="{{ $building->id }}">{{ $building->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Select Floor</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <select class="form-select mb-3 @error('floor_id') border border-danger @enderror" name="floor_id">
                                        <option disabled>Select A Floor</option>
                                        @foreach ($floors as $floor)
                                            <option {{ $partition->floor_id === $floor->id ? 'selected' : '' }} value="{{ $floor->id }}">{{ $floor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Select Flat</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <select class="form-select mb-3 @error('flat_id') border border-danger @enderror" name="flat_id">
                                        <option disabled>Select A Flat</option>
                                        @foreach ($flats as $flat)
                                            <option {{ $partition->flat_id === $flat->id ? 'selected' : '' }} value="{{ $flat->id }}">{{ $flat->flat_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
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

@section('page-specific-js')
    @include('inc.coms.selects.select-floors-from-building');
    @include('inc.coms.selects.select-flats-from-floors');
@endsection
