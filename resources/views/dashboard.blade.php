@extends('layouts.app')

@section('title')
    Dashboard | {{ config('app.name', 'PM Software') }}
@endsection

@section('content')
    {{-- Boxes --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
          <div class="card radius-10 border-start border-0 border-3 border-success">
             <div class="card-body">
                 <div class="d-flex align-items-center">
                     <div>
                         <p class="mb-0">
                             <a href="{{ route('dashboard.availablePartitions') }}" class="text-secondary">Available Partitions</a>
                        </p>
                         <h4 class="my-1">
                             <a href="{{ route('dashboard.availablePartitions') }}" class="text-success">{{ $availablePartitionsCount }}</a>
                        </h4>
                         <p class="mb-0 font-13">
                             <a href="{{ route('dashboard.availablePartitions') }}" class="text-secondary">{{ $availablePartitionsCount }} partition{{ $availablePartitionsCount >= 2 ? 's' : '' }} {{ $availablePartitionsCount >= 2 ? 'are' : 'is' }} currently available</a>
                        </p>
                     </div>
                 </div>
             </div>
          </div>
        </div>
        {{-- <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0"><a href="" class="text-secondary">Available Bedspaces in 3 Days</a></p>
                            <h4 class="my-1"><a href="" class="text-primary"></a></h4>
                            <p class="mb-0 font-13"><a href="" class="text-secondary"> bedspaces, in the next 3 days</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0">
                                <a href="{{ route('dashboard.PartitionsOnNotice') }}" class="text-secondary">Partitions On Notice</a>
                            </p>
                            <h4 class="my-1">
                                <a href="{{ route('dashboard.PartitionsOnNotice') }}" class="text-danger">{{ $partitionsOnNoticeCount }}</a>
                            </h4>
                            <p class="mb-0 font-13">
                                <a href="{{ route('dashboard.PartitionsOnNotice') }}" class="text-secondary">{{ $partitionsOnNoticeCount }} partition{{ $partitionsOnNoticeCount >= 2 ? 's' : '' }} {{ $partitionsOnNoticeCount >= 2 ? 'are' : 'is' }} on notice</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0"><a href="{{ route('dashboard.newTenants') }}" class="text-secondary">New Tenants</a></p>
                            <h4 class="my-1"><a href="{{ route('dashboard.newTenants') }}" class="text-warning">{{ $newTenantsWithin1Month }}</a></h4>
                            <p class="mb-0 font-13"><a href="{{ route('dashboard.newTenants') }}" class="text-secondary">{{ $newTenantsWithin1Month }} new tenant{{ $newTenantsWithin1Month >= 2 ? 's' : '' }} in the last 30 days</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0"><a href="{{ route('dashboard.invoicesToBePaidWithin7Days') }}" class="text-secondary">Invoices To Be Paid</a></p>
                            <h4 class="my-1"><a href="{{ route('dashboard.invoicesToBePaidWithin7Days') }}" class="text-primary">{{ number_format($invoices->count(), 0, '.', ',') }}</a></h4>
                            <p class="mb-0 font-13"><a href="{{ route('dashboard.invoicesToBePaidWithin7Days') }}" class="text-secondary">To be paid within 7 days</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0"><a href="{{ route('dashboard.duedInvoices') }}" class="text-secondary">Dued Invoices</a></p>
                            <h4 class="my-1"><a href="{{ route('dashboard.duedInvoices') }}" class="text-danger">{{ number_format($duedInvoices->count(), 0, '.', ',') }}</a></h4>
                            <p class="mb-0 font-13"><a href="{{ route('dashboard.duedInvoices') }}" class="text-secondary">Invoices that are already dued</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Operations Overview --}}
    <div class="row">
        {{-- Buildings --}}
        {{-- <div class="col">
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 font-14"><a class="text-secondary" title="Click To View" href="{{ route('buildings.index') }}">Buildings</a></p>
                            <h5 class="my-0"><a class="text-dark" title="Click To View" href="{{ route('buildings.index') }}">{{ $buildingsCount }}</a></h5>
                        </div>
                        <a class="ms-auto text-primary font-30" title="Click To View" href="{{ route('buildings.index') }}">
                            <i class='bx bxs-city' ></i>
                        </a>
                    </div>
                 </div>
            </div>
        </div> --}}

        {{-- Floors --}}
        <div class="col">
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 font-14"><a class="text-secondary" title="Click To View" href="{{ route('floors.index') }}">Floors</a></p>
                            <h5 class="my-0"><a class="text-dark" title="Click To View" href="{{ route('floors.index') }}">{{ $floorsCount }}</a></h5>
                        </div>
                        <a href="{{ route('floors.index') }}" title="Click To View"  class="text-primary ms-auto font-30">
                            <i class='bx bx-building'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flats --}}
        <div class="col">
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 font-14"><a class="text-secondary" title="Click To View" href="{{ route('flats.index') }}">Flats</a></p>
                            <h5 class="my-0"><a class="text-dark" title="Click To View" href="{{ route('flats.index') }}">{{ $flatsCount }}</a></h5>
                        </div>
                        <a class="text-dark ms-auto font-30" title="Click To View" href="{{ route('flats.index') }}">
                            <i class='bx bx-square-rounded' ></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Available Cards --}}
        <div class="col">
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 font-14"><a class="text-secondary" title="Click To View" href="{{ route('cards.availableCards') }}">Available Cards</a></p>
                            <h5 class="my-0"><a class="text-dark" title="Click To View" href="{{ route('cards.availableCards') }}">{{ $availableCardsCount }}</a></h5>
                        </div>
                        <a class="text-success ms-auto font-30" title="Click To View" href="{{ route('cards.availableCards') }}">
                            <i class='bx bx-credit-card-front bx-rotate-180' ></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Invoices --}}
        <div class="col">
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 font-14"><a class="text-secondary" title="Click To View" href="{{ route('dashboard.todaysInvoices') }}">Today Invoices</a></p>
                            <h5 class="my-0"><a class="text-dark" title="Click To View" href="{{ route('dashboard.todaysInvoices') }}">{{ $todaysInvoicesCount }}</a></h5>
                        </div>
                        <a class="text-warning ms-auto font-30" title="Click To View" href="{{ route('dashboard.todaysInvoices') }}">
                            <i class='bx bx-grid'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Balances --}}
        <div class="col">
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 font-14"><a class="text-secondary" title="Click To View" href="{{ route('dashboard.toPayBalances') }}">Balances</a></p>
                            <h5 class="my-0"><a class="text-dark" title="Click To View" href="{{ route('dashboard.toPayBalances') }}">{{ $balancesToReceiveCount }}</a></h5>
                        </div>
                        <a class="text-danger ms-auto font-30" title="Click To View" href="{{ route('dashboard.toPayBalances') }}">
                            <i class='bx bx-money'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Deposits --}}
        <div class="col">
            <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 font-14"><a class="text-secondary" title="Click To View" href="#">Total Deposit <i class='bx bx-info-circle' title="Total fixed deposit amount for all time"></i></a></p>
                            <h5 class="my-0"><a class="text-dark" title="Click To View" href="#">{{ number_format($totalFixedDepositAmount, 0, '.', ',') }} <small>{{ $settings->currency }}</small></a></h5>
                        </div>
                        {{-- <a class="ms-auto text-primary font-30" title="Click To View" href="#">
                            <i class='bx bx-wallet'></i>
                        </a> --}}
                    </div>
                 </div>
            </div>
        </div>
      </div>

    {{-- Recent Transactions Table --}}
    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
                 <div>
                     <h6 class="mb-3 mt-2">Recent Transactions <small><a class="text-dark" href="{{ route('invoices.index') }}">(See All)</a></small></h6>
                 </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                 <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Invoice Date</th>
                    <th>Transaction No.</th>
                    <th>Tenant Name</th>
                    <th>ID/Passport</th>
                    <th>Partition / Flat / Floor / Building</th>
                    <th>Start Date</th>
                    <th class="text-end">Amount</th>
                    <th class="text-end">Balance</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($recentTransactions as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ date('d M, Y', strtotime($transaction->created_at)) }}</td>
                            <td><a title="Click To View" class="text-dark" href="{{ route('invoices.show', $transaction->id) }}">{{ $transaction->invoice_prefix }}{{ $transaction->invoice_no }}</a></td>
                            <td><a title="Click To View" class="text-dark" href="{{ route('tenants.show', $transaction->tenant->id) }}">{{ $transaction->tenant->name }}</a></td>
                            <td><a title="Click To View" class="text-dark" href="{{ route('tenants.show', $transaction->tenant->id) }}">{{ $transaction->tenant->idorpassport }}</a></td>
                            <td>
                                <a class="text-dark cursor-pointer" title="View" data-bs-toggle="modal" data-bs-target="#partitionShowButton{{ $transaction->partition_id }}">{{ $transaction->partition->p_number }}</a> /
                                <a class="text-dark" title="View" href="{{ route('flats.show', $transaction->flat_id) }}">{{ $transaction->flat->flat_no }}</a> /
                                <a class="text-dark" title="View" href="{{ route('floors.show', $transaction->floor_id) }}">{{ $transaction->floor->name }}</a> /
                                <a class="text-dark" title="View" href="{{ route('buildings.show', $transaction->building->slug) }}">{{ $transaction->building->name }}</a>

                                {{-- Show Partition Modal --}}
                                @include('inc.coms.modals.show-partition-modal-via-transaction')
                            </td>
                            <td>{{ date('d M, Y', strtotime($transaction->start_date)) }}</td>
                            <td class="text-end">{{ number_format($transaction->total_price, 0, '.', ',') }} {{ $transaction->currency }}</td>
                            <td class="text-end">{{ number_format($transaction->balance, 0, '.', ',') }} {{ $transaction->currency }}</td>
                        </tr>
                    @endforeach
                 </tbody>
               </table>
            </div>
        </div>
    </div>

    {{-- Recent PayBalances Table --}}
    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
                 <div>
                     <h6 class="mb-3 mt-2">Recent PayBalances <small><a class="text-dark" href="{{ route('invoices.balance.index') }}">(See All)</a></small></h6>
                 </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                 <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Payment Date</th>
                    <th>Transaction No.</th>
                    <th>Tenant Name</th>
                    <th>ID/Passport</th>
                    <th>Partition / Flat / Floor / Building</th>
                    <th>Start Date</th>
                    <th class="text-end">Amount</th>
                    <th class="text-end">Balance</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($recentPaybalances as $index => $paybalance)
                      <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ date('d M, Y', strtotime($paybalance->created_at)) }}</td>
                            <td><a title="Click To View" class="text-dark" href="{{ route('invoices.show', $paybalance->invoice_id) }}">{{ $paybalance->invoice->invoice_prefix }}{{ $paybalance->invoice->invoice_no }}</a></td>
                            <td><a title="Click To View" class="text-dark" href="{{ route('tenants.show', $paybalance->tenant->id) }}">{{ $paybalance->tenant->name }}</a></td>
                            <td><a title="Click To View" class="text-dark" href="{{ route('tenants.show', $paybalance->tenant->id) }}">{{ $paybalance->tenant->idorpassport }}</a></td>
                            <td>
                                <a class="text-dark cursor-pointer" title="View" data-bs-toggle="modal" data-bs-target="#partitionShowButtonPayBalance{{ $paybalance->partition_id }}">{{ $paybalance->partition->p_number }}</a> /
                                <a class="text-dark" title="View" href="{{ route('flats.show', $paybalance->flat_id) }}">{{ $paybalance->flat->flat_no }}</a> /
                                <a class="text-dark" title="View" href="{{ route('floors.show', $paybalance->floor_id) }}">{{ $paybalance->floor->name }}</a> /
                                <a class="text-dark" title="View" href="{{ route('buildings.show', $paybalance->building->slug) }}">{{ $paybalance->building->name }}</a>

                                <div class="modal" id="partitionShowButtonPayBalance{{ $paybalance->partition_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form class="d-inline">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $paybalance->partition->p_number }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="d-block mb-2"><strong>Status:</strong>
                                                        @if ($paybalance->partition->status == 'available')
                                                            <span class="text-success">Available</span>
                                                        @elseif ($paybalance->partition->status == 'occupied')
                                                            <span class="text-warning">Occupied</span>
                                                        @elseif ($paybalance->partition->status == 'notice')
                                                            <span class="text-danger">On Notice</span>
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
                            <td class="text-end">{{ number_format($paybalance->current_payment_amount, 0, '.', ',') }} {{ $paybalance->currency }}</td>
                            <td class="text-end">{{ number_format($paybalance->balance, 0, '.', ',') }} {{ $paybalance->currency }}</td>
                        </tr>
                    @endforeach
                 </tbody>
               </table>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Recent Card Receipts --}}
        <div class="col-12 col-lg-7 col-xl-8">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-3 mt-2">Recent Card Receipts <small><a class="text-dark" href="{{ route('invoices.cards.index') }}">(See All)</a></small></h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table align-middle table-light table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Card ID</th>
                                    <th>ID/Passport</th>
                                    <th>Card Price</th>
                                    <th>Status</th>
                                    <th>Issued Date</th>
                                    <th>Returned Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentCardReceipts as $index => $cardReceipt)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td title="Click To View" data-bs-toggle="modal" data-bs-target="#cardReceiptViewButton{{ $cardReceipt->id }}" class="cursor-pointer">{{ $cardReceipt->card->code }}</td>
                                        <td><a title="Click To View" class="text-dark" href="{{ route('tenants.show', $cardReceipt->tenant->id) }}">{{ $cardReceipt->tenant->name }}</a></td>
                                        <td>{{ $cardReceipt->card_price }} {{ $cardReceipt->currency }}</td>
                                        <td>
                                            @if($cardReceipt->receipt_status == 'issued')
                                                <span class="text-warning">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                            @elseif ($cardReceipt->receipt_status == 'returned')
                                                <span class="text-success">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                            @else
                                                <span class="text-danger">{{ ucfirst($cardReceipt->receipt_status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d M, Y', strtotime($cardReceipt->issued_date)) }}</td>
                                        <td>{{ $cardReceipt->returned_date ? date('d M, Y', strtotime($cardReceipt->returned_date)) : '-' }}</td>
                                    </tr>

                                    {{-- View Modal --}}
                                    <div class="modal" id="cardReceiptViewButton{{ $cardReceipt->id }}" tabindex="-1" aria-hidden="true">
                                        <form class="d-inline" action="{{ route('invoices.cards.show', $cardReceipt->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Card Receipt</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Tenant:</strong> {{ $cardReceipt->tenant->name }}</p>
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
                                                            <p><strong>Issued Date:</strong> {{ $cardReceipt->returned_date }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <a target="_blank" href="{{ route('invoices.cards.print', $cardReceipt->id) }}" class="btn btn-primary">Print Or Download</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- New Tenants --}}
        <div class="col-12 col-lg-5 col-xl-4">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-3 mt-2">New Tenants <small><a class="text-dark" href="{{ route('tenants.index') }}">(See All)</a></small></h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table align-middle table-light table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newTenants as $index => $tenant)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $tenant->name }}</td>
                                        <td>{{ $tenant->country_id ? $tenant->country->name : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
