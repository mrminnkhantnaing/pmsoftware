@extends('layouts.app')

@section('title')
    {{ $paybalance->invoice->invoice_prefix }}{{ $paybalance->invoice->invoice_no }} - Pay Balance | {{ config('app.name', 'PM Software') }}
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
                    <li class="breadcrumb-item">
                        <a class="text-secondary" href="{{ route('invoices.balance.index') }}">PAY BALANCE</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">FOR {{ $paybalance->invoice->invoice_prefix }}{{ $paybalance->invoice->invoice_no }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a class="btn btn-primary" href="{{ route('invoices.balance.index') }}">BACK</a>
                <a class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end" style="">
                    <a class="dropdown-item" href="{{ route('invoices.balance.edit', $paybalance->id) }}" id="print-invoice">EDIT {{ $settings->invoice_prefix }}{{ $paybalance->invoice->invoice_no }}</a>
                    <a class="dropdown-item" href="{{ route('invoices.balance.print', $paybalance->id) }}" id="print-invoice" target="_blank">PRINT OR DOWNLOAD</a>
                    {{-- <form action="{{ route('sendInvoice', $paybalance->id) }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-uppercase" type="submit">SEND EMAIL TO {{ $paybalance->invoice->tenant->name }}</button>
                    </form> --}}
                </div>
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
                            <div class="row">
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
                                        <label for="disabled_invoice_no" class="form-label">Created At</label>
                                        <p class="show-invoice-fields">{{ date('d M, Y', strtotime($paybalance->created_at)) }}</p>
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
                                        <p class="show-invoice-fields">{{ $paybalance->no_of_tenant }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="price" class="form-label">Price ({{ $paybalance->currency }})</label>
                                        <p class="show-invoice-fields">{{ number_format($paybalance->price, 0, '.', ',') }}</p>
                                    </div>
                                </div>

                                {{-- 4th Row --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Start Date</label>
                                        <p class="show-invoice-fields">{{ date('d M, Y', strtotime($paybalance->start_date)) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">End Date</label>
                                        <p class="show-invoice-fields">{{ date('d M, Y', strtotime($paybalance->end_date)) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="sub_total" class="form-label">Sub Total ({{ $paybalance->currency }})</label>
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
                                        <p class="show-invoice-fields">{{ $paybalance->card_id ? $paybalance->card->code : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="status">Card Status</label>
                                        <p class="show-invoice-fields">{{ $paybalance->card_id ? ucfirst($paybalance->card->status) : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="grand_total" class="form-label">Grand Total ({{ $paybalance->currency }})</label>
                                        <p class="show-invoice-fields">{{ number_format($paybalance->total_price, 0, '.', ',') }}</p>
                                    </div>
                                </div>

                                {{-- 6th Row --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label" for="invoice_type">Invoice Type</label>
                                        <p class="show-invoice-fields">{{ ucfirst($paybalance->invoice_type) }}</p>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="payment_amount" class="form-label">Payment Amount ({{ $paybalance->currency }})</label>
                                        <p class="show-invoice-fields">{{ number_format($paybalance->initial_payment_amount, 0, '.', ',') }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Current Payment Amount</label>
                                        <p class="show-invoice-fields">{{ number_format($paybalance->current_payment_amount, 0, '.', ',') }}</p>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="balance" class="form-label">Balance ({{ $paybalance->currency }})</label>
                                        <p class="show-invoice-fields">{{ number_format($paybalance->balance, 0, '.', ',') }}</p>
                                    </div>
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
                        <footer style="border-top: 1px solid {{ $settings->invoice_theme_color }};">Invoice was created on a computer and is valid without the signature and seal.</footer>
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
