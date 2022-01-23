@extends('layouts.app')

@section('title')
    {{ $tenant->name }} | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('tenants.index') }}">TENANTS</a>
                    </li>
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">{{ $tenant->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a class="btn btn-primary" href="{{ route('tenants.index') }}">BACK</a>
                @can('edit tenants')
                    <a class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end" style="">
                        <a class="dropdown-item text-uppercase" href="{{ route('tenants.edit', $tenant->id) }}" id="print-invoice">EDIT {{ $tenant->name }}</a>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    {{-- Tenant --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                {{-- Tenant Details --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="my-3">{{ $tenant->name }}</h5>
                                <span class="d-block mb-2"><strong>ID/Passport:</strong> {{ $tenant->idorpassport }}</span>
                                <span class="d-block mb-2"><strong>WhatsApp:</strong> {{ $tenant->whatsapp_no }}</span>
                                @if ($tenant->phone_no)
                                    <span class="d-block mb-2"><strong>Phone:</strong> {{ $tenant->phone_no }}</span>
                                @endif
                                @if ($tenant->email)
                                    <span class="d-block mb-2"><strong>Email:</strong> {{ $tenant->email }}</span>
                                @endif
                                <span class="d-block mb-2"><strong>Gender:</strong> {{ ucfirst($tenant->gender) }}</span>
                                <span class="d-block mb-2"><strong>Country:</strong> {{ $tenant->country_id ? $tenant->country->name : '' }}</span>
                            </div>
                            <div class="col-md-6">
                                <h5 class="my-3">Other Status</h5>
                                <span class="d-block mb-2"><strong>Total Invoices:</strong> {{ $transactions->count() }}</span>
                                <span class="d-block mb-2"><strong>Total Amount Spent:</strong> {{ number_format($totalPrice, 0, '.', ',') }} {{ $settings->currency }}</span>
                                <span class="d-block mb-2"><strong>Living Status:</strong>
                                    @if ($tenant->status == 1)
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Inactive</span>
                                    @endif
                                </span>
                                @if ($tenant->joined_date)
                                    <span class="d-block mb-2"><strong>Joined Date:</strong>
                                        {{ date('d M, Y', strtotime($tenant->joined_date)) }}
                                    </span>
                                @endif
                                @if ($tenant->fixed_deposit)
                                    <span class="d-block mb-2"><strong>Fixed Deposit:</strong>
                                        {{ number_format($tenant->fixed_deposit, 0, '.', ',') }} {{ $settings->currency }}
                                        @if ($tenant->fixed_deposit_model()->exists())
                                            <i class='bx bx-info-circle' title="Last updated on {{ date('d M, Y (h:i A)', strtotime($tenant->fixed_deposit_model->updated_at)) }}"></i>
                                        @endif
                                    </span>
                                @endif
                                @if ($tenant->previous_balance)
                                    <span class="d-block mb-2"><strong>Previous Balance:</strong>
                                        {{ number_format($tenant->previous_balance, 0, '.', ',') }} {{ $settings->currency }}
                                        @if ($tenant->fixed_deposit_model()->exists())
                                            <i class='bx bx-info-circle' title="Previous balance of this tenant"></i>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Transactions --}}
                @if ($transactions->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3 mt-2">Transactions</h5>
                            <div class="table-responsive">
                                <table id="transactions" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Invoice No.</th>
                                            <th>Partition / Flat / Floor / Building</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
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
                                                        {{-- Delete Modal --}}
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
                                                    @endcan
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
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Balance</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Paybalances --}}
                @if ($paybalances->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3 mt-2">Pay Balances</h5>
                            <div class="table-responsive">
                                <table id="paybalances" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Invoice No.</th>
                                            <th>Partition / Flat / Floor / Building</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th class="text-center">Paid Amount</th>
                                            <th class="text-center">Balance</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paybalances as $index => $paybalance)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><a class="text-dark" title="View" href="{{ route('invoices.show', $paybalance->invoice_id) }}">{{ $paybalance->invoice->invoice_prefix }}{{ $paybalance->invoice->invoice_no }}</a></td>
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
                                                                                <span class="text-danger">Occupied</span>
                                                                            @elseif ($paybalance->partition->status == 'notice')
                                                                                <span class="text-warning">On Notice</span>
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
                                                <td>{{ date('d M, Y', strtotime($paybalance->start_date)) }}</td>
                                                <td>{{ date('d M, Y', strtotime($paybalance->end_date)) }}</td>
                                                <td class="text-end">{{ number_format($paybalance->current_payment_amount, 0, '.', ',') }} {{ $paybalance->currency }}</td>
                                                <td class="text-end">{{ number_format($paybalance->balance, 0, '.', ',') }} {{ $paybalance->currency }}</td>
                                                <td>
                                                    <a class="btn btn-outline-dark" title="View" href="{{ route('invoices.balance.show', $paybalance->id) }}">
                                                        <i class='bx bx-show me-0'></i>
                                                    </a>

                                                    @can('edit invoices')
                                                        <a class="btn btn-outline-primary" title="Edit" href="{{ route('invoices.edit', $paybalance->id) }}">
                                                            <i class='bx bx-edit-alt me-0'></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete invoices')
                                                        {{-- Button Delete Modal --}}
                                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#paybalanceDeleteButton{{ $paybalance->id }}">
                                                            <i class='bx bx-trash me-0'></i>
                                                        </button>
                                                        {{-- Delete Modal --}}
                                                        <div class="modal" id="paybalanceDeleteButton{{ $paybalance->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <form class="d-inline" action="{{ route('invoices.destroy', $paybalance->id) }}" method="POST">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Delete paybalance</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Are you sure you want to delete this paybalance ({{ $paybalance->invoice_prefix }}{{ $paybalance->invoice_no }})?</p>
                                                                            <span class="d-block text-danger">Note</span>
                                                                            <span>It's related card's status will be changed to 'lost'.</span>
                                                                            <span class="d-block">It's related bedspaces' status will be changed to 'available'.</span>

                                                                            <input type="hidden" name="bedspace_id" value="{{ $paybalance->bedspace_id }}">
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
                                            <th>Invoice No.</th>
                                            <th>Partition / Flat / Floor / Building</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th class="text-center">Paid Amount</th>
                                            <th class="text-center">Balance</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Cardreceipts --}}
                @if ($cardreceipts->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3 mt-2">Card Receipts</h5>
                            <div class="table-responsive">
                                <table id="cardreceipts" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Card ID</th>
                                            <th>ID/Passport</th>
                                            <th>Issued Date</th>
                                            <th>Status</th>
                                            <th>Paid Amount</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cardreceipts as $index => $cardReceipt)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $cardReceipt->card->code }}</td>
                                                <td>
                                                    <a class="text-dark" title="View" href="{{ route('tenants.show', $cardReceipt->tenant_id) }}">{{ $cardReceipt->tenant->idorpassport }}</a>
                                                </td>
                                                <td>{{ date('d M, Y', strtotime($cardReceipt->issued_date)) }}</td>
                                                <td>
                                                    @if($cardReceipt->receipt_status == 'issued')
                                                        <span class="text-warning">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                    @elseif ($cardReceipt->receipt_status == 'returned')
                                                        <span class="text-success">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                    @else
                                                        <span class="text-danger">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $cardReceipt->card_price }} {{ $cardReceipt->currency }}</td>
                                                <td>0 {{ $cardReceipt->currency }}</td>

                                                <td>
                                                    {{-- Button View Modal --}}
                                                    <button type="button" class="btn btn-outline-dark" title="View" data-bs-toggle="modal" data-bs-target="#cardReceiptViewButton{{ $cardReceipt->id }}">
                                                        <i class='bx bx-show me-0'></i>
                                                    </button>
                                                    {{-- View Modal --}}
                                                    <div class="modal fade" id="cardReceiptViewButton{{ $cardReceipt->id }}" tabindex="-1" style="display: none;" aria-hidden="true">

                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Card Receipt</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form class="d-inline" action="{{ route('invoices.cards.show', $cardReceipt->id) }}" method="POST">
                                                                            @csrf
                                                                            <p><strong>Tenant:</strong> {{ $cardReceipt->tenant->name }} ({{ $cardReceipt->tenant->idorpassport }})</p>
                                                                            <p><strong>Card ID:</strong> {{ $cardReceipt->card->code }}</p>
                                                                            <p><strong>Card Price:</strong> {{ $cardReceipt->card_price }} {{ $cardReceipt->currency }}</p>
                                                                            <p><strong>Receipt Status:</strong>
                                                                                @if($cardReceipt->receipt_status == 'issued')
                                                                                    <span class="text-warning">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                                                @elseif ($cardReceipt->receipt_status == 'returned')
                                                                                    <span class="text-success">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                                                @else
                                                                                    <span class="text-danger">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                                                                @endif
                                                                            </p>
                                                                            <p><strong>Issued Date:</strong> {{ date('d M, Y', strtotime($cardReceipt->issued_date)) }}</p>
                                                                            @if ($cardReceipt->returned_date)
                                                                                <p><strong>Returned Date:</strong> {{ date('d M, Y', strtotime($cardReceipt->returned_date)) }}</p>
                                                                            @endif
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        {{-- Download Receipt --}}
                                                                        <a target="_blank" href="{{ route('invoices.cards.print', $cardReceipt->id) }}" class="btn btn-primary">Print Or Download</a>
                                                                        {{-- Send Receipt --}}
                                                                        {{-- <form action="{{ route('sendReceipt', $cardReceipt->id) }}" method="POST">
                                                                            @csrf
                                                                            <button class="btn btn-outline-primary text-uppercase" type="submit">SEND EMAIL TO {{ $cardReceipt->tenant->name }}</button>
                                                                        </form> --}}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>

                                                    @can('edit cardreceipts')
                                                        {{-- Button Edit Modal --}}
                                                        <button type="button" class="btn btn-outline-primary"  title="Edit" data-bs-toggle="modal" data-bs-target="#cardReceiptEditButton{{ $cardReceipt->id }}">
                                                            <i class='bx bx-edit-alt me-0'></i>
                                                        </button>
                                                        {{-- Edit Modal --}}
                                                        <div class="modal" id="cardReceiptEditButton{{ $cardReceipt->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <form class="d-inline" action="{{ route('invoices.cards.update', $cardReceipt->id) }}" method="POST">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit Card Receipt</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label for="idorpassport" class="form-label">Passport No.</label>
                                                                                    <input disabled type="text" class="form-control @error('tenant_id') border border-danger @enderror" name="idorpassport" value="{{ $cardReceipt->tenant->idorpassport }}" id="idorpassport" placeholder="Eg. ME123456">
                                                                                    <input type="hidden" name="tenant_id" value="{{ $cardReceipt->tenant_id }}" />
                                                                                    @error('tenant_id')
                                                                                        <small class="text-danger">{{ $message }}</small>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="col-md-6 mb-3">
                                                                                    <label for="name" class="form-label">Full Name</label>
                                                                                    <input disabled type="text" class="form-control @error('tenant_id') border border-danger @enderror" value="{{ $cardReceipt->tenant->name }}" name="name" id="name" placeholder="Eg. Frank William">
                                                                                    @error('tenant_id')
                                                                                        <small class="text-danger">{{ $message }}</small>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label class="form-label" for="code">Card ID</label>
                                                                                    <input disabled type="text" class="form-control" id="code" name="code" placeholder="Eg. 10000001" value="{{  $cardReceipt->card->code }}" />
                                                                                    @error('card_id')
                                                                                        <small class="text-danger">{{ $message }}</small>
                                                                                    @enderror

                                                                                    <input type="hidden" name="card_id" value="{{ $cardReceipt->card_id }}" />
                                                                                    <input type="hidden" name="card_price" value="{{ $cardReceipt->card_price }}">
                                                                                    <input type="hidden" name="currency" value="{{ $cardReceipt->currency }}">
                                                                                </div>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label class="form-label">Issued Date</label>
                                                                                    <input disabled type="text" class="form-control @error('issued_date') border border-danger @enderror" name="issued_date" placeholder="Pick Issued Date" value="{{ date('d M, Y', strtotime($cardReceipt->issued_date)) }}" />
                                                                                    @error('issued_date')
                                                                                        <small class="text-danger">{{ $message }}</small>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label class="form-label" for="status">Receipt Status</label>
                                                                                    <select class="form-select @error('receipt_status') border border-danger @enderror" name="receipt_status">
                                                                                        <option value="{{ $cardReceipt->receipt_status }}">{{ ucfirst($cardReceipt->receipt_status) }} (Current)</option>
                                                                                        <option value="issued">Issued</option>
                                                                                        <option value="returned">Returned</option>
                                                                                        <option value="lost">Lost</option>
                                                                                    </select>
                                                                                    @error('receipt_status')
                                                                                        <small class="text-danger">{{ $message }}</small>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="col-md-6 mb-3">
                                                                                    <label class="form-label">Returned Date</label>
                                                                                    <input type="text" class="form-control datepicker" name="returned_date" placeholder="Pick Returned Date" value="{{ $cardReceipt->returned_date ? date('d M, Y', strtotime($cardReceipt->issued_date)) : '' }}" />
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button class="btn btn-primary" type="submit">Update</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endcan

                                                    @can('delete cardreceipts')
                                                        {{-- Button Delete Modal --}}
                                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#cardReceiptDeleteButton{{ $cardReceipt->id }}">
                                                            <i class='bx bx-trash me-0'></i>
                                                        </button>
                                                        {{-- Modal --}}
                                                        <div class="modal" id="cardReceiptDeleteButton{{ $cardReceipt->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <form class="d-inline" action="{{ route('invoices.cards.destroy', $cardReceipt->id) }}" method="POST">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Delete Card Receipt</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <span>Are you sure you would like to delete this Card Receipt?</span>
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
                                            <th>Card ID</th>
                                            <th>ID/Passport</th>
                                            <th>Issued Date</th>
                                            <th>Status</th>
                                            <th>Paid Amount</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#transactions').DataTable();
            $('#paybalances').DataTable();
            $('#cardreceipts').DataTable();
        } );
    </script>
@endsection
