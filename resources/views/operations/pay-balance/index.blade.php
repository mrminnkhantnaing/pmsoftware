@extends('layouts.app')

@section('title')
    PayBalance Invoices | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('invoices.balance.index') }}">INVOICE</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">PAYBALANCE INVOICES ({{ $paybalances->count() }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('create paybalances')
                <div class="btn-group">
                    <a class="btn btn-primary" href="{{ route('invoices.balance.create') }}">ADD NEW</a>
                    <a class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                        <form action="{{ route('invoices.balance.export') }}" method="POST">
                            @csrf
                            <input type="hidden" name="days" value="0">
                            <button type="submit" class="dropdown-item text-uppercase">Export For Today</button>
                        </form>
                        <form action="{{ route('invoices.balance.export') }}" method="POST">
                            @csrf
                            <input type="hidden" name="days" value="1">
                            <button type="submit" class="dropdown-item text-uppercase">EXPORT For Yesterday</button>
                        </form>
                        <form action="{{ route('invoices.balance.export') }}" method="POST">
                            @csrf
                            <input type="hidden" name="days" value="7">
                            <button type="submit" class="dropdown-item text-uppercase">EXPORT LAST 7 Days</button>
                        </form>
                        <form action="{{ route('invoices.balance.export') }}" method="POST">
                            @csrf
                            <input type="hidden" name="days" value="15">
                            <button type="submit" class="dropdown-item text-uppercase">EXPORT LAST 15 days</button>
                        </form>
                        <form action="{{ route('invoices.balance.export') }}" method="POST">
                            @csrf
                            <input type="hidden" name="days" value="30">
                            <button type="submit" class="dropdown-item text-uppercase">EXPORT LAST 30 days</button>
                        </form>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    {{-- PayBalances --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Created At</th>
                            <th>Invoice No.</th>
                            <th>ID / Passport</th>
                            <th>Partition / Flat / Floor / Building</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Paid Amount</th>
                            <th class="text-center">Balance</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paybalances as $paybalance)
                            <tr>
                                <td>{{ date('d M, Y', strtotime($paybalance->created_at)) }}</td>
                                <td>
                                    <a class="text-dark" title="View" href="{{ route('invoices.show', $paybalance->invoice_id) }}">{{ $paybalance->invoice->invoice_prefix }}{{ $paybalance->invoice->invoice_no }}</a>
                                </td>

                                <td>
                                    <a class="text-dark" title="View" href="{{ route('tenants.show', $paybalance->tenant_id) }}">{{ $paybalance->tenant->idorpassport }}</a>
                                </td>

                                <td>
                                    <a class="text-dark cursor-pointer" title="View" data-bs-toggle="modal" data-bs-target="#partitionShowButton{{ $paybalance->partition_id }}">{{ $paybalance->partition->p_number }}</a> /

                                    <a class="text-dark" title="View" href="{{ route('flats.show', $paybalance->flat_id) }}">{{ $paybalance->flat->flat_no }}</a> /

                                    <a class="text-dark" title="View" href="{{ route('floors.show', $paybalance->floor_id) }}">{{ $paybalance->floor->name }}</a> /

                                    <a class="text-dark" title="View" href="{{ route('buildings.show', $paybalance->building->slug) }}">{{ $paybalance->building->name }}</a>

                                    {{-- Show Partition Modal --}}
                                    <div class="modal" id="partitionShowButton{{ $paybalance->partition_id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form class="d-inline">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Partition {{ $paybalance->partition->p_number }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <span class="d-block mb-2"><strong>Status:</strong>
                                                            @if ($paybalance->partition->status == 'available')
                                                                <span class="text-success">Available</span>
                                                            @elseif ($paybalance->partition->status == 'occupied')
                                                                <span class="text-warning">Occupied</span>
                                                            @elseif ($paybalance->partition->status == 'notice')
                                                                <span class="text-danger">On Notice</span>
                                                            @endif
                                                        </span>
                                                        <span class="d-block mb-2"><strong>Flat:</strong> {{ $paybalance->partition->flat->flat_no }}</span>
                                                        <span class="d-block mb-2"><strong>Floor:</strong> {{ $paybalance->partition->floor->name }}</span>
                                                        <span class="d-block"><strong>Building:</strong> {{ $paybalance->partition->building->name }}</span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($paybalance->invoice_status == 'fully_paid')
                                        <span class="text-success">Fully Paid</span>
                                    @elseif ($paybalance->invoice_status == 'partially_paid')
                                        <span class="text-primary">Partially Paid</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ number_format($paybalance->current_payment_amount, 0, '.', ',') }} {{ $paybalance->currency }}</td>
                                <td class="text-end">{{ number_format($paybalance->balance, 0, '.', ',') }} {{ $paybalance->currency }}</td>
                                <td>
                                    <a class="btn btn-outline-dark" title="View" href="{{ route('invoices.balance.show', $paybalance->id) }}">
                                        <i class='bx bx-show me-0'></i>
                                    </a>

                                    @can('edit paybalances')
                                        <a class="btn btn-outline-primary" title="Edit" href="{{ route('invoices.balance.edit', $paybalance->id) }}">
                                            <i class='bx bx-edit-alt me-0'></i>
                                        </a>
                                    @endcan

                                    @can('delete paybalances')
                                        {{-- Button Triger Modal --}}
                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#paybalanceDeleteButton{{ $paybalance->id }}">
                                            <i class='bx bx-trash me-0'></i>
                                        </button>
                                        {{-- Modal --}}
                                        <div class="modal" id="paybalanceDeleteButton{{ $paybalance->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form class="d-inline" action="{{ route('invoices.balance.destroy', $paybalance->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete PayBalance</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this pay balance for ({{ $paybalance->invoice->invoice_prefix }}{{ $paybalance->invoice->invoice_no }})?</p>
                                                            <span class="text-danger">Note: It's related card's status will be changed to 'lost'.</span>
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

                            <th>Created At</th>
                            <th>Invoice No.</th>
                            <th>ID / Passport</th>
                            <th>Partition / Flat / Floor / Building</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Paid Amount</th>
                            <th class="text-center">Balance</th>
                            <th class="text-center">Action</th>
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
