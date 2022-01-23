@extends('layouts.app')

@section('title')
    {{ $building->name }} | {{ config('app.name', 'PM Software') }}
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
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">{{ $building->name }}</li>
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
                <div class="col-lg-4">
                {{-- Building Details --}}
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <h5 class="mb-3">{{ $building->name }}</h5>
                                <span class="d-block mb-2"><strong>Location:</strong> {{ $building->location }}</span>
                                <span class="d-block mb-2"><strong>Address:</strong> {{ $building->full_address }}</span>
                                <span class="d-block mb-2"><strong>No. of Floors:</strong> {{ $building->floors_count }}</span>
                                <span class="d-block mb-2"><strong>No. of Flats:</strong> {{ $building->flats_count }}</span>
                                <span class="d-block"><strong>No. of partitions:</strong> {{ $building->partitions_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5>Floors in This Building</h5>
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Floor Name</th>
                                        <th scope="col">No. of Flats</th>
                                        <th scope="col">No. of Partitions</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <span class="d-none">{{ $i = 1 }}</span>
                                    @foreach ($building->floors as $floor)
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td><a class="text-dark" title="View" href="{{ route('floors.show', $floor->id) }}">{{ $floor->name }}</a></td>
                                            <td>{{ $floor->flats->count() }}</td>
                                            <td>{{ $floor->partitions->count() }}</td>
                                            <td>
                                                <a class="btn btn-outline-dark" title="View" href="{{ route('floors.show', $floor->id) }}">
                                                    <i class='bx bx-show me-0'></i>
                                                </a>

                                            </td>
                                        </tr>
                                        <span class="d-none">{{ $i++ }}</span>
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
