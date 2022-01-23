@extends('layouts.app')

@section('title')
    All Buildings | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('buildings.index') }}">BUILDING</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">ALL BUILDINGS ({{ $buildingsCount }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('buildings.create') }}">ADD NEW</a>
        </div>
    </div>

    {{-- Main Profile --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">No. of Floors</th>
                                    <th scope="col">No. of Rooms</th>
                                    <th scope="col">No. of Partitions</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buildings as $index => $building)
                                    <tr>
                                        <th scope="row">{{ $index + $buildings->firstItem() }}</th>
                                        <td>{{ $building->name }}</td>
                                        <td>{{ $building->floors_count }}</td>
                                        <td>{{ $building->rooms_count }}</td>
                                        <td>{{ $building->partitions_count }}</td>
                                        <td>
                                            <a class="btn btn-outline-dark" title="View" href="{{ route('buildings.show', $building->slug) }}">
                                                <i class='bx bx-show me-0'></i>
                                            </a>
                                            <a class="btn btn-outline-primary" title="Edit" href="{{ route('buildings.edit', $building->slug) }}">
                                                <i class='bx bx-edit-alt me-0'></i>
                                            </a>
                                            {{-- Button Triger Modal --}}
                                            <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#buildingDeleteButton">
                                                <i class='bx bx-trash me-0'></i>
                                            </button>
                                            {{-- Modal --}}
                                            <div class="modal" id="buildingDeleteButton" tabindex="-1" aria-hidden="true">
                                                <form class="d-inline" action="{{ route('buildings.destroy', $building->slug) }}" method="GET">
                                                    @csrf
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Building</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you would like to delete this building ({{ $building->name }})?</p>
                                                                <em>Note: you would not be able to retrieve this building after you delete. And every floor, room, partition & bedspace will also be lost forever!</em>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <span class="ms-3">{{ $buildings->links() }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
