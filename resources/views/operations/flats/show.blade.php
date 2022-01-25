@extends('layouts.app')

@section('title')
    {{ $flat->flat_no }} | {{ config('app.name', 'PM Software') }}
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
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">{{ $flat->flat_no }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('flats.index') }}">Back</a>
        </div>
    </div>

    {{-- Flat --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    {{-- Flat Details --}}
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <h5 class="mb-3">{{ $flat->flat_no }}</h5>
                                <span class="d-block mb-2"><strong>Building:</strong> <a class="text-dark" href="{{ route('buildings.show', $flat->building->slug) }}">{{ $flat->building->name }}</a></span>
                                <span class="d-block mb-2"><strong>Floor:</strong> <a class="text-dark" href="{{ route('floors.show', $flat->floor_id) }}">{{ $flat->floor->name }}</a></span>
                                <span class="d-block"><strong>No. of partitions:</strong> {{ $flat->partitions_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5>Partitions in This Flat</h5>
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Partition No.</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Current Tenant</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($flat->partitions as $index => $partition)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>
                                                <a class="text-dark" href="{{ route('partitions.show', $partition->id) }}" title="View" data-bs-toggle="modal" data-bs-target="#partitionShowButton{{ $partition->id }}">{{ $partition->p_number }}</a>
                                            </td>
                                            <td>
                                                @if ($partition->status == 'available')
                                                    <span class="text-success">Available</span>
                                                @elseif ($partition->status == 'occupied')
                                                    <span class="text-warning">Occupied</span>
                                                @elseif ($partition->status == 'notice')
                                                    <span class="text-danger">On Notice</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($partition->status !== 'available')
                                                    <a class="text-dark" href="{{ route('tenants.show', $partition->transactions->first()->tenant_id) }}">
                                                        {{ $partition->transactions->first()->tenant->name }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{-- Show Partition Button --}}
                                                <button type="button" class="btn btn-outline-dark" title="View" data-bs-toggle="modal" data-bs-target="#partitionShowButton{{ $partition->id }}">
                                                    <i class='bx bx-show me-0' title="View"></i>
                                                </button>
                                                {{-- Partition Modal --}}
                                                <div class="modal" id="partitionShowButton{{ $partition->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form class="d-inline">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">{{ $partition->p_number }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <span class="d-block mb-2"><strong>Status:</strong>
                                                                        @if ($partition->status == 'available')
                                                                            <span class="text-success">Available</span>
                                                                        @elseif ($partition->status == 'occupied')
                                                                            <span class="text-warning">Occupied</span>
                                                                        @elseif ($partition->status == 'notice')
                                                                            <span class="text-danger">On Notice</span>
                                                                        @endif
                                                                    </span>
                                                                    <span class="d-block mb-2">
                                                                        @if ($partition->status !== 'available')
                                                                            <strong>Tenant: </strong><a class="text-dark" href="{{ route('tenants.show', $partition->transactions->first()->tenant_id) }}">
                                                                                {{ ucfirst($partition->transactions->first()->tenant->name) }}
                                                                            </a>
                                                                        @endif
                                                                    </span>
                                                                    <span class="d-block mb-2"><strong>Flat:</strong> {{ $partition->flat->flat_no }}</span>
                                                                    <span class="d-block mb-2"><strong>Floor:</strong> {{ $partition->floor->name }}</span>
                                                                    <span class="d-block"><strong>Building:</strong> {{ $partition->building->name }}</span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
