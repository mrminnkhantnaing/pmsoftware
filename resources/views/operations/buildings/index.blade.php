@extends('layouts.app')

@section('title')
    All Buildings | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
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
                    <li class="breadcrumb-item active" aria-current="page">ALL BUILDINGS ({{ $buildings->count() }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('create buildings')
                <a class="btn btn-outline-primary" href="{{ route('buildings.create') }}">ADD NEW</a>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>No. of Floors</th>
                            <th>No. of Flats</th>
                            <th>No. of Partitions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buildings as $index => $building)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a class="text-dark" title="View" href="{{ route('buildings.show', $building->slug) }}">{{ $building->name }}</a></td>
                                <td>{{ $building->location }}</td>
                                <td>{{ $building->floors_count }}</td>
                                <td>{{ $building->flats_count }}</td>
                                <td>{{ $building->partitions_count }}</td>
                                <td>
                                    <a class="btn btn-outline-dark" title="View" href="{{ route('buildings.show', $building->slug) }}">
                                        <i class='bx bx-show me-0'></i>
                                    </a>

                                    @can('edit buildings')
                                        <a class="btn btn-outline-primary" title="Edit" href="{{ route('buildings.edit', $building->slug) }}">
                                            <i class='bx bx-edit-alt me-0'></i>
                                        </a>
                                    @endcan

                                    @can('delete buildings')
                                        {{-- Button Triger Modal --}}
                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#buildingDeleteButton{{ $building->slug }}">
                                            <i class='bx bx-trash me-0'></i>
                                        </button>
                                        {{-- Modal --}}
                                        <div class="modal" id="buildingDeleteButton{{ $building->slug }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form class="d-inline" action="{{ route('buildings.destroy', $building->slug) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Building</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you would like to delete this building ({{ $building->name }})?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>No. of Floors</th>
                            <th>No. of Flats</th>
                            <th>No. of Partitions</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection
