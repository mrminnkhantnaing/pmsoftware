@extends('layouts.app')

@section('title')
    Available Cards | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @error('code')
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bx-x-circle' ></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Error Alert</h6>
                    <div class="text-white">{{ $message }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    {{-- Breadcrumb --}}
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('dashboard') }}">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('cards.index') }}">CARDS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">AVAILABLE DOOR CARDS ({{ $availableCardsCount }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            {{-- Add Card Triger Modal --}}
            <button type="button" class="btn btn-outline-primary" title="Add New" data-bs-toggle="modal" data-bs-target="#addNewCard">
                ADD NEW
            </button>
            {{-- Add Card Modal --}}
            <div class="modal" id="addNewCard" tabindex="-1" aria-hidden="true">
                <form class="d-inline" action="{{ route('cards.store') }}" method="POST">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Add New Card</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <label class="form-label">Card ID</label>
                                    <input type="number" name="code" class="form-control datepicker" placeholder="Eg. 10000001" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add New</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Cards --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="pt-3">
                                <p title="Total Cards">
                                    <strong class="text-dark">
                                        <a class="text-decoration-none text-dark" href="{{ route('cards.index') }}">Total Card{{ $cardsCount <= 1 ? '' : 's' }}:</a>
                                    </strong>
                                    {{ $cardsCount }}
                                </p>
                                <p title="Available Cards">
                                    <strong>
                                        <a class="text-decoration-none text-dark" href="{{ route('cards.availableCards') }}">Available Card{{ $availableCardsCount <= 1 ? '' : 's' }}:</a>
                                    </strong>
                                    <span class="text-success">{{ $availableCardsCount }}</span>
                                </p>
                                <p title="Active Cards">
                                    <strong>
                                        <a class="text-decoration-none text-dark" href="{{ route('cards.activeCards') }}">Active Card{{ $activeCardsCount <= 1 ? '' : 's' }}:</a>
                                    </strong>
                                    <span class="text-success">{{ $activeCardsCount }}</span>
                                </p>
                                <p title="active Cards">
                                    <strong>
                                        <a class="text-decoration-none text-dark" href="{{ route('cards.lostCards') }}">Lost Card{{ $activeCardsCount <= 1 ? '' : 's' }}:</a>
                                    </strong>
                                    <span class="text-danger">{{ $lostCardsCount }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Card ID</th>
                                            <th>Status</th>
                                            {{-- <th>Tenant</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($availableCards as $index => $card)
                                            @include('inc.coms.cards.tr-loop')
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Card ID</th>
                                            <th>Status</th>
                                            {{-- <th>Tenant</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
