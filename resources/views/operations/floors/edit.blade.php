@extends('layouts.app')

@section('title')
    Edit {{ $floor->name }} | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('floors.index') }}">FLOORS</a>
                    </li>
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">EDIT {{ $floor->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('floors.index') }}">BACK</a>
        </div>
    </div>

    {{-- Floor --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Store Floor Details --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('floors.update', $floor->id) }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-10 text-secondary">
                                    <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" value="{{ $floor->name }}" placeholder="Eg. Building One" />
                                    @error('name')
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
                                        <option disabled>Select A Building</option>
                                        @foreach ($buildings as $building)
                                            <option {{ $floor->building_id === $building->id ? 'selected' : '' }} value="{{ $building->id }}">{{ $building->name }}</option>
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
