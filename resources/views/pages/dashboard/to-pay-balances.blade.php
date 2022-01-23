@extends('layouts.app')

@section('title')
    To Pay Balances | Dashboard | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-secondary" href="{{ route('dashboard') }}">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">Balances To Receive ({{ $transactions->count() }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('create invoices')
                <a class="btn btn-primary" href="{{ route('invoices.balance.create') }}">PAY BALANCE</a>
            @endcan
        </div>
    </div>

    {{-- Transactions --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice No.</th>
                            <th>ID / Passport</th>
                            <th>Partition / Flat / Floor / Building</th>
                            <th class="text-center">Start Date</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Balance</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $index => $transaction)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a class="text-dark" title="View" href="{{ route('invoices.show', $transaction->id) }}">{{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</a></td>
                                <td><a class="text-dark" title="View" href="{{ route('tenants.show', $transaction->tenant_id) }}">{{ $transaction->tenant->idorpassport }}</a></td>
                                <td>
                                    <a class="text-dark cursor-pointer" title="View" data-bs-toggle="modal" data-bs-target="#partitionShowButton{{ $transaction->partition_id }}">{{ $transaction->partition->p_number }}</a> /
                                    <a class="text-dark" title="View" href="{{ route('flats.show', $transaction->flat_id) }}">{{ $transaction->flat->flat_no }}</a> /
                                    <a class="text-dark" title="View" href="{{ route('floors.show', $transaction->floor_id) }}">{{ $transaction->floor->name }}</a> /
                                    <a class="text-dark" title="View" href="{{ route('buildings.show', $transaction->building->slug) }}">{{ $transaction->building->name }}</a>

                                    {{-- Show Partition Modal --}}
                                    @include('inc.coms.modals.show-partition-modal-via-transaction')
                                </td>
                                <td>
                                    {{ date('d M, Y', strtotime($transaction->start_date)) }}
                                </td>
                                <td class="text-end">{{ number_format($transaction->total_price, 0, '.', ',') }} {{ $transaction->currency }}</td>
                                <td class="text-end">{{ number_format($transaction->balance, 0, '.', ',') }} {{ $transaction->currency }}</td>
                                <td>
                                    <a class="btn btn-outline-dark" title="View" href="{{ route('invoices.show', $transaction->id) }}">
                                        <i class='bx bx-show me-0'></i>
                                    </a>

                                    @can('edit invoices')
                                        <a class="btn btn-outline-primary" title="Edit" href="{{ route('invoices.edit', $transaction->id) }}">
                                            <i class='bx bx-edit-alt me-0'></i>
                                        </a>
                                    @endcan

                                    @can('delete invoices')
                                        {{-- Button Delete Modal --}}
                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#transactionDeleteButton{{ $transaction->id }}">
                                            <i class='bx bx-trash me-0'></i>
                                        </button>
                                    @endcan

                                    {{-- Notice Model --}}
                                    <div class="modal" id="transactionNoticeButton{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form class="d-inline" action="{{ route('invoices.updateNotice', $transaction->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">{{ $transaction->notice == 1 ? 'Deactivate The Notice' : 'Activate The Notice' }}</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="notice" value="{{ $transaction->notice }}">
                                                        <span>Are you sure you want to {{ $transaction->notice == 1 ? 'deactivate' : 'activate' }} the notice of this invoice?</span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                        @if ($transaction->notice == 1)
                                                            <button type="submit" class="btn btn-danger btn-sm">Deactivate</button>
                                                        @else
                                                            <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Delete Modal --}}
                                    <div class="modal" id="transactionDeleteButton{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form class="d-inline" action="{{ route('invoices.destroy', $transaction->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Delete Transaction</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <p>Are you sure you want to delete this transaction ({{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }})?</p>
                                                        <span class="d-block text-danger">Note:</span>
                                                        <span>It's related card's status will be changed to 'lost'.</span>
                                                        <span class="d-block">It's related bedspaces' status will be changed to 'available'.</span>
                                                        <span class="d-block">It's related pay balances will also be deleted.</span>

                                                        <input type="hidden" name="bedspace_id" value="{{ $transaction->bedspace_id }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Moved Model --}}
                                    <div class="modal" id="transactionMovedButton{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form class="d-inline" action="{{ route('invoices.updateMoved', $transaction->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Change Moved Status</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="moved" value="{{ $transaction->moved }}">
                                                        <span>Are you sure you want to change the moved status of this invoice?</span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                        @if ($transaction->moved == 1)
                                                            <button type="submit" class="btn btn-danger btn-sm">Unmoved</button>
                                                        @else
                                                            <button type="submit" class="btn btn-success btn-sm">Moved</button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Invoice No.</th>
                            <th>ID / Passport</th>
                            <th>Partition / Flat / Floor / Building</th>
                            <th class="text-center">Start Date</th>
                            <th class="text-center">Amount</th>
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
