@extends('layouts.app')

@section('title')
    Invoice Settings | {{ config('app.name', 'PM Software') }}
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
                        <a class="text-dark" href="{{ route('settings.general') }}">SETTINGS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">INVOICE</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-outline-primary" href="">SAVE</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-4">Invoice Settings</h5>
            <form action="{{ route('settings.updateInvoice') }}" method="POST">
                @csrf

                <div class="row mb-3 mt-3">
                    <div class="col-sm-2">
                        <h6>Invoice Prefix</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input type="text" class="form-control @error('invoice_prefix') border border-danger @enderror" name="invoice_prefix" value="{{ $settings->invoice_prefix }}" placeholder="Eg. AA" />
                        <small>The invoice prefix has been combined with the invoice number.</small>
                        @error('invoice_prefix')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4 mt-3">
                    <div class="col-sm-2">
                        <h6>Invoice Theme Color</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input style="padding: 2px;" type="color" class="form-control" name="invoice_theme_color" value="{{ $settings->invoice_theme_color }}" />
                        <small>Selected color has been used as the main theme color of the invoice.</small>
                        @error('invoice_theme_color')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <div class="col-sm-2">
                        <h6>Currency</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input type="text" class="form-control @error('currency') border border-danger @enderror" name="currency" value="{{ $settings->currency }}" placeholder="Eg. {{ $settings->currency }}" />
                        <small>Type any currency you would like to use for this system. We suggest you to stick with only one type of currency since there could be some conflicts if you change this frequently.</small>
                        @error('invoice_theme_color')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <div class="col-sm-2">
                        <h6>Door Card Price</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <input type="text" class="form-control @error('card_price') border border-danger @enderror" name="card_price" value="{{ $settings->card_price }}" placeholder="Eg. {{ $settings->card_price }}" />
                        <small>You can change the price for the door card if you would like to.</small>
                        @error('invoice_theme_color')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <div class="col-sm-2">
                        <h6>Terms & Conditions</h6>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <textarea class="form-control" name="termsnconditions" cols="30" rows="5">{{ $settings->termsnconditions }}</textarea>
                        <small class="d-block">Type something here and update to override the default terms & conditions. Clear all from the text editor to retrieve the default texts.</small>
                        @error('invoice_theme_color')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-10 text-secondary">
                        <input type="submit" class="btn btn-primary px-4" value="Update" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
