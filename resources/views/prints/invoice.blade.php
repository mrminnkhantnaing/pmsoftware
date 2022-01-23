@extends('layouts.print-app')

@section('content')
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
                            <div class="col-3">
                                <label for="disabled_invoice_no" class="form-label">Invoice Date</label>
                                <p class="show-invoice-fields">{{ date('d M, Y', strtotime($transaction->created_at)) }}</p>
                            </div>
                            <div class="col-3">
                                <label for="disabled_invoice_no" class="form-label">Invoice No.</label>
                                <p class="print-invoice-fields">{{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</p>
                            </div>
                            <div class="col-3">
                                <label for="idorpassport" class="form-label">ID/Passport</label>
                                <p class="print-invoice-fields">{{ $transaction->tenant->idorpassport }}</p>
                            </div>
                            <div class="col-3">
                                <label for="name" class="form-label">Full Name</label>
                                <p class="print-invoice-fields">{{ $transaction->tenant->name }}</p>
                            </div>
                        </div>

                        {{-- 2nd Row --}}
                        <div class="row">
                            <div class="col-4">
                                <label for="building_id" class="form-label">Building</label>
                                <p class="print-invoice-fields">{{ $transaction->building->name }}</p>
                            </div>
                            <div class="col-4">
                                <label for="floor_id" class="form-label">Floor</label>
                                <p class="print-invoice-fields">{{ $transaction->floor->name }}</p>
                            </div>
                            <div class="col-4">
                                <label for="flat_id" class="form-label">Flat</label>
                                <p class="print-invoice-fields">{{ $transaction->flat->flat_no }}</p>
                            </div>
                        </div>

                        {{-- 3rd Row --}}
                        <div class="row">
                            <div class="col-4">
                                <label for="partition_id" class="form-label">Partition No.</label>
                                <p class="print-invoice-fields">{{ $transaction->partition->p_number }}</p>
                            </div>
                            <div class="col-4">
                                <label for="no_of_tenant" class="form-label">No. of Tenant</label>
                                <p class="print-invoice-fields">{{ $transaction->no_of_tenant }}</p>
                            </div>
                            <div class="col-4">
                                <label for="price" class="form-label">Price ({{ $transaction->currency }})</label>
                                <p class="print-invoice-fields">{{ number_format($transaction->price, 0, '.', ',') }}</p>
                            </div>
                        </div>

                        {{-- 4th Row --}}
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label">Start Date</label>
                                <p class="print-invoice-fields">{{ date('d M, Y', strtotime($transaction->start_date)) }}</p>
                            </div>
                            <div class="col-4">
                                <label class="form-label">End Date</label>
                                <p class="print-invoice-fields">{{ date('d M, Y', strtotime($transaction->end_date)) }}</p>
                            </div>
                            <div class="col-4">
                                <label for="sub_total" class="form-label">Sub Total ({{ $transaction->currency }})</label>
                                <p class="print-invoice-fields">{{ number_format($transaction->sub_total, 0, '.', ',') }}</p>
                            </div>
                        </div>

                        {{-- 5th Row --}}
                        <div class="row">
                            <div class="col-3">
                                <label for="referrer_id" class="form-label">Referrer (Optional)</label>
                                <p class="print-invoice-fields">{{ $transaction->referrer_id ? ucfirst($transaction->referrer->name) : 'N/A' }}</p>
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="code">Card ID (Optional)</label>
                                <p class="print-invoice-fields">{{ $transaction->card_id ? $transaction->card->code : 'N/A' }}</p>
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="status">Card Status</label>
                                <p class="print-invoice-fields">{{ $transaction->card_id ? ucfirst($transaction->card->status) : 'N/A' }}</p>
                            </div>
                            <div class="col-3">
                                <label for="grand_total" class="form-label">Grand Total ({{ $transaction->currency }})</label>
                                <p class="print-invoice-fields">{{ number_format($transaction->total_price, 0, '.', ',') }}</p>
                            </div>
                        </div>

                        {{-- 6th Row --}}
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label" for="invoice_type">Invoice Type</label>
                                <p class="print-invoice-fields">{{ ucfirst($transaction->invoice_type) }}</p>
                            </div>

                            @if ($transaction->invoice_type == 'reservation')
                                <div class="col-3">
                                    <label for="deposit" class="form-label">Deposit ({{ $transaction->currency }})</label>
                                    <p class="print-invoice-fields">{{ number_format($transaction->deposit, 0, '.', ',') }}</p>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">Reservation Date <small class="text-danger">*</small></label>
                                    <p class="print-invoice-fields">{{ date('d M, Y', strtotime($transaction->reservation_date)) }}</p>
                                </div>
                            @endif

                            @if ($transaction->invoice_type == 'payment')
                                <div class="col-3">
                                    <label for="payment_amount" class="form-label">Payment Amount ({{ $settings->currency }})</label>
                                    <p class="print-invoice-fields">{{ number_format($transaction->payment_amount, 0, '.', ',') }}</p>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">Rest Payment Date</label>
                                    <p class="print-invoice-fields">{{ $transaction->rest_payment_date ? date('d M, Y', strtotime($transaction->rest_payment_date)) : 'N/A' }}</p>
                                </div>
                            @endif

                            <div class="col-3">
                                <label for="balance" class="form-label">Balance ({{ $transaction->currency }})</label>
                                <p class="print-invoice-fields">{{ number_format($transaction->balance, 0, '.', ',') }}</p>
                            </div>
                        </div>

                        {{-- 7th Row --}}
                        <div class="row">
                            @if ($transaction->fixed_deposit)
                                <div class="col-3">
                                    <label for="fixed_deposit" class="form-label">Fixed Deposit</label>
                                    <p class="show-invoice-fields">{{ number_format($transaction->fixed_deposit, 0, '.', ',') }} {{ $transaction->currency }}</p>
                                </div>
                            @endif

                            @if ($transaction->previous_balance)
                                <div class="col-3">
                                    <label for="name" class="form-label">Previous Balance</label>
                                    <p class="show-invoice-fields">{{ number_format($transaction->previous_balance, 0, '.', ',') }} {{ $transaction->currency }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-5">
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
        </div>
    </div>
@endsection

@section('page-specific-js')
    <script>
        document.title = '{{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}';
        setTimeout(function() {
            window.print();
        }, 1000)
    </script>
@endsection
