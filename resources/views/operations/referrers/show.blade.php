@extends('layouts.app')

@section('title')
    {{ $referrer->name }} | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('referrers.index') }}">REFERRERS</a>
                    </li>
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">{{ $referrer->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="{{ route('referrers.index') }}">BACK</a>
        </div>
    </div>

    {{-- Referrer --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Referrer Details --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="my-3">{{ $referrer->name }}</h5>
                                <span class="d-block mb-2"><strong>ID/Passport:</strong> {{ $referrer->idorpassport ? $referrer->idorpassport : 'N/A' }}</span>
                                <span class="d-block mb-2"><strong>WhatsApp:</strong> {{ $referrer->whatsapp_no ? $referrer->whatsapp_no : 'N/A' }}</span>
                                @if ($referrer->phone_no)
                                    <span class="d-block mb-2"><strong>Phone:</strong> {{ $referrer->phone_no }}</span>
                                @endif
                                @if ($referrer->email)
                                    <span class="d-block mb-2"><strong>Email:</strong> {{ $referrer->email }}</span>
                                @endif
                                <span class="d-block mb-2"><strong>Gender:</strong> {{ $referrer->gender ? ucfirst($referrer->gender) : 'N/A' }}</span>
                                <span class="d-block mb-2"><strong>Country:</strong> {{ $referrer->country_id ? $referrer->country->name : 'N/A' }}</span>
                            </div>
                            <div class="col-md-6">
                                <h5 class="my-3">Other Status</h5>
                                <span class="d-block mb-2"><strong>Total Refers:</strong> {{ $referrer->transactions->count() }}</span>
                                <span class="d-block mb-2"><strong>{{ $referrer->name }} Made Us:</strong> {{ number_format($totalPrice, 0, '.', ',') }} {{ $settings->currency }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Transactions --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="my-3">Transactions</h5>
                        <div class="table-responsive">
                            <table id="example" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No.</th>
                                        <th>Partition / Flat / Floor / Building</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referrer->transactions as $index => $transaction)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><a class="text-dark" title="View" href="{{ route('invoices.show', $transaction->id) }}">{{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</a></td>
                                            <td>
                                                <a class="text-dark cursor-pointer" title="View" data-bs-toggle="modal" data-bs-target="#partitionShowButton{{ $transaction->partition_id }}">{{ $transaction->partition->p_number }}</a> /
                                                <a class="text-dark" title="View" href="{{ route('flats.show', $transaction->flat_id) }}">{{ $transaction->flat->flat_no }}</a> /
                                                <a class="text-dark" title="View" href="{{ route('floors.show', $transaction->floor_id) }}">{{ $transaction->floor->name }}</a> /
                                                <a class="text-dark" title="View" href="{{ route('buildings.show', $transaction->building->slug) }}">{{ $transaction->building->name }}</a>

                                                {{-- Show Partition Modal --}}
                                                @include('inc.coms.modals.show-partition-modal-via-transaction')
                                            </td>
                                            <td>{{ date('d M, Y', strtotime($transaction->start_date)) }}</td>
                                            <td>{{ date('d M, Y', strtotime($transaction->end_date)) }}</td>
                                            @php
                                                $remaining_days = round(((strtotime($transaction->end_date) - strtotime(date('Y-m-d')))/24)/60/60);
                                                $arriving_days = round(((strtotime($transaction->start_date) - strtotime(date('Y-m-d')))/24)/60/60);

                                                if ($remaining_days >= 10 && $arriving_days < 0) {
                                                    echo '<td class="text-end">' . $remaining_days . ' Days Left</td>';
                                                } else if ($remaining_days < 10 && $remaining_days > 5) {
                                                    echo '<td class="text-warning text-end">' . $remaining_days . ' Days Left</td>';
                                                } else if ($remaining_days <= 5 && $remaining_days > 0) {
                                                    echo '<td class="text-danger text-end">' . $remaining_days . ' Days Left</td>';
                                                } else if ($remaining_days < 0) {
                                                    echo '<td class="text-success text-end">Completed</td>';
                                                } else if ($remaining_days == 0) {
                                                    echo '<td class="text-danger text-end">The last day</td>';
                                                } else if (strtotime(date('Y-m-d')) < strtotime($transaction->start_date)) {
                                                    echo '<td class="text-primary text-end">Arriving Soon</td>';
                                                } else if ($remaining_days >= 10) {
                                                    echo '<td class="text-end">' . $remaining_days . ' Days Left</td>';
                                                } else {
                                                    echo '<td class="text-end">-</td>';
                                                }
                                            @endphp
                                            <td class="text-end">{{ number_format($transaction->total_price, 0, '.', ',') }} {{ $transaction->currency }}</td>
                                            <td>
                                                <a class="btn btn-outline-dark" title="View" href="{{ route('invoices.show', $transaction->id) }}">
                                                    <i class='bx bx-show me-0'></i>
                                                </a>
                                                <a class="btn btn-outline-primary" title="Edit" href="{{ route('invoices.edit', $transaction->id) }}">
                                                    <i class='bx bx-edit-alt me-0'></i>
                                                </a>
                                                {{-- Button Triger Modal --}}
                                                <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#transactionDeleteButton{{ $transaction->id }}">
                                                    <i class='bx bx-trash me-0'></i>
                                                </button>
                                                {{-- Modal --}}
                                                <div class="modal" id="transactionDeleteButton{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form class="d-inline" action="{{ route('invoices.destroy', $transaction->id) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete transaction</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to delete this transaction ({{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }})?</p>
                                                                    <span class="d-block text-danger">Note</span>
                                                                    <span>It's related card's status will be changed to 'lost'.</span>
                                                                    <span class="d-block">It's related bedspaces' status will be changed to 'available'.</span>

                                                                    <input type="hidden" name="bedspace_id" value="{{ $transaction->bedspace_id }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
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
                                        <th>Partition / Flat / Floor / Building</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
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
