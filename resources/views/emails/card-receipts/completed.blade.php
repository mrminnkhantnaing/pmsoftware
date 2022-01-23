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
            background-color: #eeeeee !important;
        }

        .margin-y-5 {
            margin: 5px 0;
        }
    </style>
@endsection

@section('content')
    <div class="m-30">
        <p>Hello <em>{{ $cardReceipt->tenant->name }}</em>,</p>
        <p>We are really glad to welcome you.</p>
        <p>You can see the receipt details below or download the attached pdf to save on your device.</p>

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
                    <div class="invoice-tenant-name">{{ $cardReceipt->tenant->name }}</div>
                    <div><strong>Passport No.:</strong> {{ $cardReceipt->tenant->passport_no }}</div>
                    <div><strong>WhatsApp No.:</strong> {{ $cardReceipt->tenant->whatsapp_no }}</div>
                </div>
                <div class="invoice-required-info">
                    <div class="invoice-required-number">{{ $cardReceipt->card->code }}</div>
                    <div><strong>Issued Date:</strong> {{ date('d M, Y', strtotime($cardReceipt->start_date)) }}</div>
                    @if ($cardReceipt->returned_date)
                        <div><strong>Returned Date:</strong> {{ date('d M, Y', strtotime($cardReceipt->end_date)) }}</div>
                    @endif
                    <div><strong>Card Receipt Status:</strong>
                        @if ($cardReceipt->receipt_status == 'issued')
                            <span class="text-warning text-capitalize">{{ $cardReceipt->receipt_status }}</span>
                        @elseif ($cardReceipt->receipt_status == 'returned')
                            <span class="text-success text-capitalize">{{ $cardReceipt->receipt_status }}</span>
                        @elseif ($cardReceipt->receipt_status == 'lost')
                            <span class="text-danger text-capitalize">{{ $cardReceipt->receipt_status }}</span>
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
                        <tr>
                            <td class="theme-bg-color-text-color"><span class="left-margin">01</span></td>
                            <td class="bg-eeeeee">
                                <div class="margin-y-5">
                                    <div class="bedspace-name left-margin">{{ $cardReceipt->card->code }}</div>
                                    <span class="left-margin display-block">
                                        <strong>Notice:</strong> This card is issued separately and do not relate to the partition invoice.
                                    </span>
                                </div>
                            </td>
                            <td class="gray text-right">
                                <span class="right-margin">
                                    1
                                </span>
                            </td>
                            <td class="text-right bg-eeeeee"><span class="right-margin">{{ number_format($cardReceipt->card_price, 0, '.', ',') }} {{ $cardReceipt->currency }}</span></td>
                            <td class="theme-bg-color-text-color text-right"><span class="right-margin">{{ number_format($cardReceipt->card_price, 0, '.', ',') }} {{ $cardReceipt->currency }}</span></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td class="theme-text-color" colspan="2">GRAND TOTAL</td>
                            <td class="theme-text-color text-right right-margin">{{ number_format($cardReceipt->card_price, 0, '.', ',') }} {{ $cardReceipt->currency }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div>
                    <div class="termsnconditions">TERMS & CONDITITIONS:</div>
                    @if ($settings->termsnconditions)
                    {!! $settings->termsnconditions !!}
                    @else
                        <div>
                            <strong><em>1.1</em></strong> When <strong>{{ $cardReceipt->tenant->name }}</strong> returns the card to the office, {{ $cardReceipt->tenant->gender == 'Male' ? 'he': 'she' }} will receive {{ number_format($cardReceipt->card_price, 0, '.', ',')  }} {{ $cardReceipt->currency }} from the office for returning the card. Otherwise, no refund shall be there.
                        </div>
                        <div>
                            <strong><em>1.2</em></strong> If <strong>{{ $cardReceipt->tenant->name }}</strong> lost the card and would like to get a new one, {{ $cardReceipt->tenant->gender == 'Male' ? 'he': 'she' }} will need to pay {{ number_format($cardReceipt->card_price, 0, '.', ',')  }} {{ $cardReceipt->currency }} to the office and get new one, and {{ $cardReceipt->tenant->gender == 'Male' ? 'he': 'she' }} can always return the card then receive {{ number_format($cardReceipt->card_price, 0, '.', ',')  }} {{ $cardReceipt->currency }} back from the office.
                        </div>
                    @endif
                </div>
            </div>
            <footer><span>Invoice was created on a computer and is valid without the signature and seal.</span></footer>
        </div>

        <p>Thank you so much for being with us. The best partitions provider in Dubai.</p>
    </div>
@endsection
