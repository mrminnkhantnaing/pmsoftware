@extends('layouts.app')

@section('title')
    {{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }} | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('invoices.index') }}">INVOICE</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a class="btn btn-primary" href="{{ route('invoices.index') }}">BACK</a>
                @can('edit invoices')
                    <a class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end" style="">
                        <a class="dropdown-item" href="{{ route('invoices.edit', $transaction->id) }}" id="print-invoice">EDIT {{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</a>
                        <a class="dropdown-item" href="{{ route('invoices.print', $transaction->id) }}" id="print-invoice" target="_blank">PRINT OR DOWNLOAD</a>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    {{-- Invoices --}}
    <div class="card">
        <div class="card-body">
            <div id="invoice">
                <div class="invoice overflow-auto">
                    <div style="min-width: 600px">
                        <header style="border-bottom: 1px solid {{ $settings->invoice_theme_color }};">
                            <div class="row mb-2">
                                <div class="col">
                                    <a href="javascript:;">
                                        <img src="{{ $settings->company_logo ? asset('storage/images/invoice_logos/' . $settings->company_logo) : asset('storage/images/invoice_logos/tkd_logo_element.png') }}" width="80" alt="{{ $settings->company_name }}" />
                                    </a>
                                </div>
                                <div class="col company-details">
                                    <h3 class="name mb-2" style="color: {{ $settings->invoice_theme_color }};">
                                        {{ $settings->company_name }}
                                    </h3>
                                    <div>{{ $settings->company_address }}</div>
                                    <div>{{ $settings->company_phone_no }}</div>
                                    <div>{{ $settings->company_email }}</div>
                                </div>
                            </div>
                        </header>
                        <main>
                            <div class="my-4">
                                {{-- 1st Row --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="disabled_invoice_no" class="form-label">Invoice Date</label>
                                        <p class="show-invoice-fields">{{ date('d M, Y', strtotime($transaction->created_at)) }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="disabled_invoice_no" class="form-label">Invoice No.</label>
                                        <p class="show-invoice-fields">{{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="idorpassport" class="form-label">ID/Passport</label>
                                        <p class="show-invoice-fields">{{ $transaction->tenant->idorpassport }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <p class="show-invoice-fields">{{ $transaction->tenant->name }}</p>
                                    </div>
                                </div>

                                {{-- 2nd Row --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="building_id" class="form-label">Building</label>
                                        <p class="show-invoice-fields">{{ $transaction->building->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="floor_id" class="form-label">Floor</label>
                                        <p class="show-invoice-fields">{{ $transaction->floor->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="flat_id" class="form-label">Flat</label>
                                        <p class="show-invoice-fields">{{ $transaction->flat->flat_no }}</p>
                                    </div>
                                </div>

                                {{-- 3rd Row --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="partition_id" class="form-label">Partition</label>
                                        <p class="show-invoice-fields">{{ $transaction->partition->p_number }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="no_of_tenant" class="form-label">No. of Tenant</label>
                                        <p class="show-invoice-fields">{{ $transaction->no_of_tenant }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="price" class="form-label">Price ({{ $transaction->currency }})</label>
                                        <p class="show-invoice-fields">{{ number_format($transaction->price, 0, '.', ',') }}</p>
                                    </div>
                                </div>

                                {{-- 4th Row --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Start Date</label>
                                        <p class="show-invoice-fields">{{ date('d M, Y', strtotime($transaction->start_date)) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">End Date</label>
                                        <p class="show-invoice-fields">{{ date('d M, Y', strtotime($transaction->end_date)) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="sub_total" class="form-label">Sub Total ({{ $transaction->currency }})</label>
                                        <p class="show-invoice-fields">{{ number_format($transaction->sub_total, 0, '.', ',') }}</p>
                                    </div>
                                </div>

                                {{-- 5th Row --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="referrer_id" class="form-label">Referrer</label>
                                        <p class="show-invoice-fields">{{ $transaction->referrer_id ? ucfirst($transaction->referrer->name) : 'N/A'}}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="code">Card ID</label>
                                        <p class="show-invoice-fields">{{ $transaction->card_id ? $transaction->card->code : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="status">Card Status</label>
                                        <p class="show-invoice-fields">{{ $transaction->card_id ? ucfirst($transaction->card->status) : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="grand_total" class="form-label">Grand Total ({{ $transaction->currency }})</label>
                                        <p class="show-invoice-fields">{{ number_format($transaction->total_price, 0, '.', ',') }}</p>
                                    </div>
                                </div>

                                {{-- 6th Row --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label" for="invoice_type">Invoice Type</label>
                                        <p class="show-invoice-fields">{{ ucfirst($transaction->invoice_type) }}</p>
                                    </div>

                                    @if ($transaction->invoice_type == 'reservation')
                                        <div class="col-md-3">
                                            <label for="deposit" class="form-label">Deposit ({{ $transaction->currency }})</label>
                                            <p class="show-invoice-fields">{{ number_format($transaction->deposit, 0, '.', ',') }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Reservation Date <small class="text-danger">*</small></label>
                                            <p class="show-invoice-fields">{{ date('d M, Y', strtotime($transaction->reservation_date)) }}</p>
                                        </div>
                                    @endif

                                    @if ($transaction->invoice_type == 'payment')
                                        <div class="col-md-3">
                                            <label for="payment_amount" class="form-label">Payment Amount ({{ $transaction->currency }})</label>
                                            <p class="show-invoice-fields">{{ number_format($transaction->payment_amount, 0, '.', ',') }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Rest Payment Date</label>
                                            <p class="show-invoice-fields">{{ $transaction->rest_payment_date ? date('d M, Y', strtotime($transaction->rest_payment_date)) : 'N/A' }}</p>
                                        </div>
                                    @endif

                                    <div class="col-md-3">
                                        <label for="balance" class="form-label">Balance ({{ $transaction->currency }})</label>
                                        <p class="show-invoice-fields">{{ number_format($transaction->balance, 0, '.', ',') }}</p>
                                    </div>
                                </div>

                                {{-- 7th Row --}}
                                <div class="row">
                                    @if ($transaction->fixed_deposit)
                                        <div class="col-md-3">
                                            <label for="fixed_deposit" class="form-label">Fixed Deposit</label>
                                            <p class="show-invoice-fields">{{ number_format($transaction->fixed_deposit, 0, '.', ',') }} {{ $transaction->currency }}</p>
                                        </div>
                                    @endif

                                    @if ($transaction->previous_balance)
                                        <div class="col-md-3">
                                            <label for="name" class="form-label">Previous Balance</label>
                                            <p class="show-invoice-fields">{{ number_format($transaction->previous_balance, 0, '.', ',') }} {{ $transaction->currency }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <h6>TERMS & CONDITITIONS:</h6>
                                    @if ($settings->termsnconditions)
                                    {!! $settings->termsnconditions !!}
                                    @else
                                        <div>
                                            <strong><em>1.1</em></strong> Partition {{ $transaction->partition->p_number }}, Room {{ $transaction->flat->flat_no }}, {{ $transaction->floor->name }}, {{ $transaction->building->name }} has been rented by <strong>{{ $transaction->tenant->name }}</strong>.
                                        </div>
                                        <div>
                                            <strong><em>1.2</em></strong> The duration is from <em>{{ date('d M, Y', strtotime($transaction->start_date)) }}</em> to <em>{{ date('d M, Y', strtotime($transaction->end_date)) }}</em> at the price of
                                            {{ number_format($transaction->sub_total, 0, '.', ',')  }} {{ $transaction->currency }}
                                            / Month.
                                            @if ($transaction->card_id)
                                                (+{{ number_format($transaction->card_price, 0, '.', ',')  }} {{ $transaction->currency }}
                                                for the door card.)
                                            @endif
                                        </div>
                                        @if($transaction->card_id)
                                            <div>
                                                <strong><em>1.3</em></strong> When <strong>{{ $transaction->tenant->name }}</strong> returns the card to the office, {{ $transaction->tenant->gender == 'Male' ? 'he': 'she' }} will receive
                                                {{ number_format($transaction->card_price, 0, '.', ',')  }} {{ $transaction->currency }}
                                                from the office for returning the card. Otherwise, no refund shall be there.
                                            </div>
                                            <div>
                                                <strong><em>1.4</em></strong> If <strong>{{ $transaction->tenant->name }}</strong> lost the card and would like to get a new one, {{ $transaction->tenant->gender == 'Male' ? 'he': 'she' }} will need to pay
                                                {{ number_format($transaction->card_price, 0, '.', ',')  }} {{ $transaction->currency }}
                                                to the office and get new one, and {{ $transaction->tenant->gender == 'Male' ? 'he': 'she' }} can always return the card then receive
                                                {{ number_format($transaction->card_price, 0, '.', ',')  }} {{ $transaction->currency }}
                                                back from the office.
                                            </div>
                                        @endif
                                        @if ($transaction->payment_amount > 0 && $transaction->balance > 0)
                                            <div>
                                                <strong><em>2.1</em></strong> <strong>{{ $transaction->tenant->name }}</strong> has paid {{ number_format($transaction->payment_amount, 0, '.', ',')  }} {{ $transaction->currency }} for this invoice. {{ $transaction->tenant->gender == 'Male' ? 'He': 'She' }} will have to pay the rest payment ({{ number_format($transaction->balance, 0, '.', ',')  }} {{ $transaction->currency }}) on {{ date('d M, Y', strtotime($transaction->rest_payment_date)) }}.
                                            </div>
                                        @elseif ($transaction->deposit > 0 && $transaction->balance > 0)
                                            <div>
                                                <strong><em>2.1</em></strong> <strong>{{ $transaction->tenant->name }}</strong> has paid {{ number_format($transaction->deposit, 0, '.', ',')  }} {{ $transaction->currency }} as deposit for this reservation invoice. {{ $transaction->tenant->gender == 'Male' ? 'He': 'She' }} will have to pay the rest payment ({{ number_format($transaction->balance, 0, '.', ',')  }} {{ $transaction->currency }}) on {{ date('d M, Y', strtotime($transaction->start_date)) }} when he joins.
                                            </div>
                                        @endif
                                        <div>
                                            <strong><em>3.1</em></strong> You need to give one month notice before leaving the partition.
                                        </div>
                                        <div>
                                            <strong><em>3.2</em></strong> Drinking & smoking are not allowed inside the partition.
                                        </div>
                                    @endif
                                </div>
                                <div class="col-4 position-relative">
                                    <p class="tenants-signature">Tenant's Signature</p>
                                </div>
                            </div>
                        </main>
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div>
                        <footer style="border-top: 1px solid {{ $settings->invoice_theme_color }};">Invoice was created on a computer and is valid without the signature and seal.</footer>
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <div class="text-primary">{{ $transaction->notice == 1 ? 'On Notice' : '' }}</div>
                <div class="text-primary ms-auto">{{ $transaction->moved == 1 ? 'Already Moved' : '' }}</div>
            </div>
        </div>
    </div>

    {{-- Pay Balances --}}
    @if ($paybalances->count() > 0)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title my-3">
                    Pay Balances
                </h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tenant Name</th>
                            <th>ID/Passport</th>
                            <th>Partition / Flat / Floor / Building</th>
                            <th>Status</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paybalances as $index => $paybalance)
                            <tr>
                                <td class="align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle"><a class="text-dark" title="View" href="{{ route('invoices.show', $paybalance->invoice_id) }}">{{ $paybalance->tenant->name }}</a></td>
                                <td class="align-middle"><a class="text-dark" title="View" href="{{ route('invoices.show', $paybalance->invoice_id) }}">{{ $paybalance->tenant->idorpassport }}</a></td>
                                <td class="align-middle">
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
                                <td class="align-middle">
                                    @if ($paybalance->invoice_status == 'fully_paid')
                                        <span class="text-success">Fully Paid</span>
                                    @elseif ($paybalance->invoice_status == 'partially_paid')
                                        <span class="text-warning">Partially Paid</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ number_format($paybalance->current_payment_amount, 0, '.', ',') }} {{ $paybalance->currency }}</td>
                                <td class="align-middle">{{ number_format($paybalance->balance, 0, '.', ',') }} {{ $paybalance->currency }}</td>
                                <td class="align-middle">
                                    <a class="btn btn-outline-dark" title="View" href="{{ route('invoices.balance.show', $paybalance->id) }}">
                                        <i class='bx bx-show me-0'></i>
                                    </a>

                                    @can('edit paybalances')
                                        <a class="btn btn-outline-primary" title="Edit" href="{{ route('invoices.balance.edit', $paybalance->id) }}">
                                            <i class='bx bx-edit-alt me-0'></i>
                                        </a>
                                    @endcan

                                    @can('delete paybalances')
                                        {{-- Button Delete Modal --}}
                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#paybalanceDeleteButton{{ $paybalance->id }}">
                                            <i class='bx bx-trash me-0'></i>
                                        </button>
                                        {{-- Delete Modal --}}
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
                </table>
            </div>
        </div>
    @endif
@endsection
