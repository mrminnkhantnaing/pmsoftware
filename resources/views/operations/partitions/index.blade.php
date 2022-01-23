@extends('layouts.app')

@section('title')
    All Partitions | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('partitions.index') }}">PARTITIONS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">ALL PARTITIONS ({{ $partitions->count() }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('create partitions')
                <a class="btn btn-outline-primary" href="{{ route('partitions.create') }}">ADD NEW</a>
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
                            <th>Partition No.</th>
                            <th>Status</th>
                            <th>Building</th>
                            <th>Floor</th>
                            <th>Flat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partitions as $index => $partition)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td title="View" class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#partitionShowButton{{ $partition->id }}">{{ $partition->p_number }}</td>
                                <td>
                                    @if ($partition->status == 'available')
                                        <span class="text-success">Available</span>
                                    @elseif ($partition->status == 'occupied')
                                        <span class="text-danger">Occupied</span>
                                    @elseif ($partition->status == 'notice')
                                        <span class="text-warning">On Notice</span>
                                    @endif
                                </td>
                                <td><a class="text-dark" title="View" href="{{ route('buildings.show', $partition->building->slug) }}">{{ $partition->building->name }}</a></td>
                                <td><a class="text-dark" title="View" href="{{ route('floors.show', $partition->floor_id) }}">{{ $partition->floor->name }}</a></td>
                                <td><a class="text-dark" title="View" href="{{ route('flats.show', $partition->flat_id) }}">{{ $partition->flat->flat_no }}</a></td>
                                <td>
                                    {{-- Show Partition Button --}}
                                    <button type="button" class="btn btn-outline-dark" title="View" data-bs-toggle="modal" data-bs-target="#partitionShowButton{{ $partition->id }}">
                                        <i class='bx bx-show me-0' title="View"></i>
                                    </button>
                                    {{-- Show Partition Modal --}}
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
                                                                <span class="text-danger">Occupied</span>
                                                            @elseif ($partition->status == 'notice')
                                                                <span class="text-warning">On Notice</span>
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

                                    @can('edit partitions')
                                        <a class="btn btn-outline-primary" title="Edit" href="{{ route('partitions.edit', $partition->id) }}">
                                            <i class='bx bx-edit-alt me-0'></i>
                                        </a>
                                    @endcan

                                    @can('delete partitions')
                                        {{-- Delete Partition Button --}}
                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#partitionDeleteButton{{ $partition->id }}">
                                            <i class='bx bx-trash me-0'></i>
                                        </button>
                                        {{-- Delete Partition Modal --}}
                                        <div class="modal" id="partitionDeleteButton{{ $partition->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form class="d-inline" action="{{ route('partitions.destroy', $partition->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Partition</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you would like to delete this partition ({{ $partition->p_number }})?</p>
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
                            <th>Partition No.</th>
                            <th>Status</th>
                            <th>Building</th>
                            <th>Floor</th>
                            <th>Flat</th>
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
