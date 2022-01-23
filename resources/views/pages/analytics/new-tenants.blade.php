@extends('layouts.app')

@section('title')
    New Tenants | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('analytics.tenants') }}">ANALYTICS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">NEW TENANTS ({{ $newTenants->count() }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('tenants.create') }}">ADD NEW</a>
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
                            <th>ID/Passport</th>
                            <th>WhatsApp</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newTenants as $index => $tenant)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $tenant->name }}</td>
                                <td>{{ $tenant->idorpassport }}</td>
                                <td>{{ $tenant->whatsapp_no }}</td>
                                <td>{{ $tenant->country->name }}</td>
                                @if ($tenant->status == 1)
                                    <td class="text-success">Active</td>
                                @else
                                    <td class="text-danger">Inactive</td>
                                @endif
                                <td>
                                    <a class="btn btn-outline-dark" title="View" href="{{ route('tenants.show', $tenant->id) }}">
                                        <i class='bx bx-show me-0'></i>
                                    </a>
                                    <a class="btn btn-outline-primary" title="Edit" href="{{ route('tenants.edit', $tenant->id) }}">
                                        <i class='bx bx-edit-alt me-0'></i>
                                    </a>
                                    {{-- Button Triger Modal --}}
                                    <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#tenantDeleteButton{{ $tenant->id }}">
                                        <i class='bx bx-trash me-0'></i>
                                    </button>
                                    {{-- Modal --}}
                                    <div class="modal" id="tenantDeleteButton{{ $tenant->id }}" tabindex="-1" aria-hidden="true">
                                        <form class="d-inline" action="{{ route('tenants.destroy', $tenant->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete tenant</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you would like to delete this tenant ({{ $tenant->name }})?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>ID/Passport</th>
                            <th>WhatsApp</th>
                            <th>Country</th>
                            <th>Status</th>
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
