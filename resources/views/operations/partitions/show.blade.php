@extends('layouts.app')

@section('title')
    {{ $partition->p_number }} | {{ config('app.name', 'PM Software') }}
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
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">{{ $partition->r_number }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('partitions.index') }}">Back</a>
        </div>
    </div>

    {{-- Partition --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    {{-- Partition Details --}}
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <h5 class="mb-3">{{ $partition->p_number }}</h5>
                                <span class="d-block mb-2"><strong>Building:</strong> {{ $partition->building->name }}</span>
                                <span class="d-block mb-2"><strong>Floor:</strong> {{ $partition->floor->name }}</span>
                                <span class="d-block mb-2"><strong>Flat:</strong> {{ $partition->flat->flat_no }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
