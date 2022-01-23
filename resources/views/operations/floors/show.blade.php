@extends('layouts.app')

@section('title')
    {{ $floor->name }} | {{ config('app.name', 'PM Software') }}
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
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">{{ $floor->name }}</li>
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
                <div class="col-lg-4">
                    {{-- Floor Details --}}
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <h5 class="mb-3">{{ $floor->name }}</h5>
                                <span class="d-block mb-2"><strong>Building:</strong> <a class="text-dark" title="View" href="{{ route('buildings.show', $floor->building->slug) }}">{{ $floor->building->name }}</a></span>
                                <span class="d-block mb-2"><strong>No. of Flats:</strong> {{ $floor->flats_count }}</span>
                                <span class="d-block"><strong>No. of partitions:</strong> {{ $floor->partitions_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5>Flats in This Floor</h5>
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Flat No.</th>
                                        <th scope="col">No. of Partitions</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($floor->flats as $index => $flat)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td><a class="text-dark" href="{{ route('flats.show', $flat->id) }}">{{ $flat->flat_no }}</a></td>
                                            <td>{{ $flat->partitions->count() }}</td>
                                            <td>
                                                <a class="btn btn-outline-dark" href="{{ route('flats.show', $flat->id) }}">
                                                    <i class='bx bx-show me-0' title="View"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
