@extends('layouts.email-app')

@section('page-specific-head-scripts')
    <style>
        p.h4 {
            font-size: 14px;
        }

        p {
            font-size: 10px;
        }

        .m-30 {
            margin: 30px;
        }

        .invoice {
            max-width: 600px;
            font-size: 10px;
            border: 1px solid {{ $settings->invoice_theme_color }};
        }

        /* Invoice Header */
        .invoce-header {
            margin-left: 10px;
            margin-right: 10px;
            display: flex;
            text-align: right;
            border-bottom: 1px solid {{ $settings->invoice_theme_color }};
        }

        .invoice-image-wrapper {
            margin-top: 15px;
        }

        .invoice-image {
            width: auto;
            height: 60px;
        }

        .invoice-company-wrapper {
            margin-left: auto;
        }

        .invoice-company-info {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .company-name {
            margin-bottom: 5px;
            font-size: 14px;
            color: {{ $settings->invoice_theme_color }};
        }

        .company-info {
            margin-bottom: 2px;
        }

        /* Invoice Heading Info */
        .invocie-heading-info {
            display: flex;
            margin-top: 15px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .invoice-tenant-name {
            font-size: 13px;
            font-weight: bold;
        }

        .invoice-required-info {
            margin-right: 10px;
            margin-left: auto;
            text-align: right;
        }

        .invoice-required-number {
            font-size: 12px;
            color: {{ $settings->invoice_theme_color }};
        }

        /* Invoice Table */

        .invoice-table {
            width: 100%;
        }

        .invoice-table-wrapper {
            margin: 15px 10px 80px;

        }

        .invoice-table thead tr th {
            font-size: 10px;
        }

        .invoice-table tbody tr td div.bedspace-name, .invocie-card-number {
            font-weight: bold;
            font-size: 11px;
            color: {{ $settings->invoice_theme_color }};
        }

        .invoice-table tfoot tr td {
            font-size: 10px !important;
        }

        .table-total {
            width: 60px;
        }

        .table-price {
            width: 55px;
        }

        .table-number {
            width: 20px;
        }

        /* Temrs & Conditions */
        .termsnconditions {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Footer */
        footer {
            margin: 10px;
            text-align: center;
            border-top: 1px solid {{ $settings->invoice_theme_color }} !important;
        }

        footer span {
            margin-top: 10px;
            margin-bottom: 5px;
            display: block;
        }

        /* Components */
        .theme-bg-color-text-color {
            color: #fff;
            background-color: {{ $settings->invoice_theme_color }} !important;
        }

        .theme-text-color {
            color: {{ $settings->invoice_theme_color }} !important;
        }

        .paid {
            color: green;
        }

        .unpaid {
            color: red;
        }

        .display-block {
            display: block;
        }

        .gray {
            color: #fff;
            background-color: #c5c5c5 !important;
        }

        .bg-white {
            background-color: #fff !important;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .right-margin {
            display: block;
            margin-right: 5px;
        }

        .left-margin {
            display: block;
            margin-left: 5px;
        }

        .table-head-cell-margin {
            margin: 10px;
        }

        .bg-eeeeee {
            background-color: #eeeeee;
        }

        .margin-y-5 {
            margin: 5px 0;
        }
    </style>
@endsection

@section('content')
    <div class="m-30">
        <p>Hello <em>{{ $transaction->tenant->name }}</em>,</p>
        <p>We are really glad to welcome you.</p>
        <p>You can see the invoice details below or download the attached pdf to save on your device.</p>

        {{-- Invoice --}}
        <div class="invoice">
            <div class="invoce-header">
                <div class="invoice-image-wrapper">
                    <img class="invoice-image" src="{{ $settings->company_logo ? asset('storage/images/invoice_logos/' . $settings->company_logo) : asset('storage/images/invoice_logos/tkd_logo_element.png') }}" alt="{{ $settings->company_name }}" />
                </div>
                <div class="invoice-company-wrapper">
                    <div class="invoice-company-info">
                        <p class="company-name">{{ $settings->company_name }}</p>
                        <div class="company-info">{{ $settings->company_address }}</div>
                        <div class="company-info">{{ $settings->company_phone_no }}</div>
                        <div class="company-info">{{ $settings->company_email }}</div>
                    </div>
                </div>
            </div>
            <div class="invocie-heading-info">
                <div class="invoice-tenant-info">
                    <div>INVOICE TO:</div>
                    <div class="invoice-tenant-name">{{ $transaction->tenant->name }}</div>
                    <div><strong>Passport No.:</strong> {{ $transaction->tenant->passport_no }}</div>
                    <div><strong>WhatsApp No.:</strong> {{ $transaction->tenant->whatsapp_no }}</div>
                </div>
                <div class="invoice-required-info">
                    <div class="invoice-required-number">{{ $transaction->invoice_prefix . $transaction->invoice_no }}</div>
                    <div><strong>Start Date:</strong> {{ date('d M, Y', strtotime($transaction->start_date)) }}</div>
                    <div><strong>Due Date:</strong> {{ date('d M, Y', strtotime($transaction->end_date)) }}</div>
                    <div><strong>Invoice Status:</strong>
                        @if ($transaction->invoice_status == 'paid')
                            <span class="paid">Paid</span>
                        @else
                            <span class="unpaid">Unpaid</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="invoice-table-wrapper">
                <table class="invoice-table">
                    <thead>
                        <tr class="bg-eeeeee">
                            <th class="table-number"><div class="table-head-cell-margin">#</div></th>
                            <th><div class="table-head-cell-margin">DESCRIPTION</div></th>
                            <th><div class="table-head-cell-margin">QTY</div></th>
                            <th class="table-price"><div class="table-head-cell-margin">PRICE</div></th>
                            <th class="table-total"><div class="table-head-cell-margin">TOTAL</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->bedspace_transactions as $index => $bs_transaction)
                            <tr class="bg-eeeeee">
                                <td class="theme-bg-color-text-color"><span class="left-margin">0{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="left-margin margin-y-5">
                                        <div class="bedspace-name">{{ $bs_transaction->bedspace->name }}</div>
                                        <span class="display-block">
                                            <strong>Partition No.:</strong> {{ $bs_transaction->bedspace->partition->p_number }},
                                            <strong>Room No.:</strong> {{ $bs_transaction->bedspace->room->r_number }},
                                            <strong>Floor:</strong> {{ $bs_transaction->bedspace->floor->name }},
                                            <strong>Building:</strong> {{ $bs_transaction->bedspace->building->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="gray text-right">
                                    <span class="right-margin">
                                        @include('inc.coms.calculations.calculate-months-and-show-qty-invoice')
                                    </span>
                                </td>
                                <td class="text-right bg-eeeeee"><span class="right-margin">{{ number_format($bs_transaction->transaction->price / $transaction->bedspace_transactions->count(), 0, '.', ',') }} {{ $bs_transaction->transaction->currency }}</span></td>
                                <td class="theme-bg-color-text-color text-right"><span class="right-margin">{{ number_format($bs_transaction->transaction->price / $transaction->bedspace_transactions->count(), 0, '.', ',') }} {{ $bs_transaction->transaction->currency }}</span></td>
                            </tr>
                        @endforeach

                        {{-- Sub Total --}}
                        <tr>
                            <td class="bg-white" colspan="2"></td>
                            <td class="bg-white theme-text-color text-right" colspan="2">SUB TOTAL</td>

                            <td class="bg-white theme-text-color text-right">{{ number_format($transaction->sub_total, 0, '.', ',') }} {{ $transaction->currency }}</td>
                        </tr>

                        {{-- If card exists --}}
                        @if($transaction->card_id)
                            <tr>
                                <td class="theme-bg-color-text-color">
                                    <span class="left-margin">
                                        01
                                    </span>
                                </td>
                                <td class="text-left bg-eeeeee">
                                    <div class="margin-y-5">
                                        <div class="invocie-card-number"><strong>{{ $transaction->card->code }}</strong></div>
                                        <span class="d-block mt-2">
                                            Card for extra
                                            {{ number_format($transaction->card_price, 0, '.', ',')  }} {{ $transaction->currency }}
                                            . (This will be paid back when the tenant returns the door card.)
                                        </span>
                                    </div>
                                </td>
                                <td class="gray text-right">
                                    <span class="right-margin">
                                        1
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span class="right-margin">
                                        {{ number_format($transaction->card_price, 0, '.', ',')  }} {{ $transaction->currency }}
                                    </span>
                                </td>

                                <td class="theme-bg-color-text-color text-right">
                                    <span class="right-margin">
                                        {{ number_format($transaction->card_price, 0, '.', ',')  }} {{ $transaction->currency }}
                                    </span>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td class="theme-text-color" colspan="2">GRAND TOTAL</td>
                            <td class="theme-text-color">{{ number_format($transaction->total_price, 0, '.', ',') }} {{ $transaction->currency }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div>
                    <div class="termsnconditions">TERMS & CONDITITIONS:</div>
                    @if ($settings->termsnconditions)
                    {!! $settings->termsnconditions !!}
                    @else
                        <div>
                            <strong><em>1.1</em></strong> The bedspace from Partition {{ $transaction->partition->p_number }}, Room {{ $transaction->room->r_number }}, {{ $transaction->floor->name }}, {{ $transaction->building->name }} has been rented by <strong>{{ $transaction->tenant->name }}</strong>.
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
                    @endif
                </div>
            </div>
            <footer><span>Invoice was created on a computer and is valid without the signature and seal.</span></footer>
        </div>

        <p>Thank you so much for being with us. The best partitions provider in Dubai.</p>
    </div>
@endsection
