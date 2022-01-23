<?php

namespace App\Http\Controllers\Operations;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Flat;
use App\Models\Floor;
use App\Models\Tenant;
use App\Models\Setting;
use App\Models\Building;
use App\Models\Referrer;
use App\Models\Partition;
use App\Models\PayBalance;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Models\CardReceipt;
use Illuminate\Support\Facades\Cache;

class TransactionController extends Controller
{
    // Show All Invoices
    public function index() {
        $transactions = Cache::remember('transactions-index', now()->addDay(), function() {
            return Transaction::with(['tenant', 'building', 'floor', 'flat', 'partition', 'partition.building', 'partition.floor', 'partition.flat'])->latest()->get();
        });

        $settings = Setting::orderBy('invoice_prefix', 'asc')->first();

        return view('operations.invoices.index', compact('transactions', 'settings'));
    }

    // Create Invoice
    public function create() {
        $lastInvoice = Transaction::orderBy('invoice_no', 'desc')->first();
        $settings = Setting::orderBy('invoice_prefix', 'desc')->first();
        $buildings = Building::orderBy('name', 'asc')->get();
        $floors = Floor::orderBy('name', 'asc')->get();
        $flats = Flat::orderBy('flat_no', 'asc')->get();
        $partitions = Partition::orderBy('p_number', 'asc')->get();
        $referrers = Referrer::orderBy('name')->get();

        return view('operations.invoices.create', compact('lastInvoice','settings', 'buildings', 'floors', 'flats', 'partitions', 'referrers'));
    }

    // Store Invoice
    public function store(Request $request) {
        $request->validate([
            'invoice_no' => 'required',
            'invoice_type' => 'required',
            'deposit' => 'required_if:invoice_type,reservation',
            'reservation_date' => 'required_if:invoice_type,reservation',
            'payment_amount' => 'required_if:invoice_type,payment',
            'tenant_id' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
            'flat_id' => 'required',
            'partition_id' => 'required',
            'no_of_tenant' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'start_date' => 'required',
            'end_date' => 'required',
            'sub_total' => 'required|integer|min:1',
            'grand_total' => 'required|integer|min:1',
        ],
        [
            'tenant_id.required' => 'The passport number & name fields are required.',
            'building_id.required' => 'The building field is required',
            'floor_id.required' => 'The floor field is required',
            'flat_id.required' => 'The flat field is required',
            'no_of_tenant.required' => 'The number of tenant field is required',
            'partition_id.required' => 'The partition field is required',
            'invoice_type.required' => 'Invoice type field is required',
            'deposit.required_if' => 'The deposit field is required',
            'reservation_date.required_if' => 'The reservation date field is required',
            'payment_amount.required_if' => 'The payment amount field is required',
        ]);

        // Check if balance is greater than zero and invoice_type is payment
        // if ($request->grand_total > $request->payment_amount && $request->invoice_type == 'payment' && $request->rest_payment_date == null) {
        //     return redirect()->route('invoices.create')->with('error', 'Rest payment date is required if the payment amount is not enough!');
        // }

        // Check if balance is greater than zero and so error if so
        if ($request->grand_total < $request->payment_amount) {
            return redirect()->route('invoices.create')->with('error', 'Balance must be greater than zero!');
        }

        // Calculate Balance
        $balance = 0;
        if ($request->payment_amount) {
            $balance = $request->grand_total - $request->payment_amount;
        } else if ($request->deposit) {
            $balance = $request->grand_total - $request->deposit;
        }

        // Invoice Status
        $invoice_status = '';
        if ($balance == 0) {
            $invoice_status = 'fully_paid';
        } else if ($balance > 0) {
            $invoice_status = 'partially_paid';
        }

        // Change Partition Status
        $partition = Partition::firstWhere('id', $request->partition_id);
        $partition->update([
            'status' => 'occupied'
        ]);

        // Change Tenant Status
        $tenant = Tenant::firstWhere('id', $request->tenant_id);
        $tenant->update([
            'status' => 1
        ]);

        // Change created another invoices of tenant
        $tenantsTransactions = Transaction::whereDate('end_date', '<=', Carbon::now()->addDays(7)->toDateTimeString())
                                ->where('tenant_id', $tenant->id)
                                ->where('notice', 0)
                                ->where('moved', 0)
                                ->get();

        if ($tenantsTransactions->count() >= 1) {
            $tenantsTransactions->map(function($transaction) {
                $transaction->update([
                    'created_another_invoice' => 1,
                ]);
            });
        }

        $transaction = Transaction::create([
            'invoice_no' => $request->invoice_no,
            'invoice_prefix' => $request->invoice_prefix,
            'tenant_id' => $request->tenant_id,
            'invoice_status' => 'paid',
            'invoice_type' => $request->invoice_type,
            'building_id' => $request->building_id,
            'floor_id' => $request->floor_id,
            'flat_id' => $request->flat_id,
            'partition_id' => $request->partition_id,
            'no_of_tenant' => $request->no_of_tenant,
            'price' => $request->price,
            'start_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->start_date))),
            'end_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->end_date))),
            'card_id' => $request->card_id ? $request->card_id : null,
            'card_price' => $request->card_id ? $request->card_price : null,
            'currency' => $request->currency,
            'sub_total' => $request->sub_total,
            'total_price' => $request->grand_total,
            'payment_amount' => $request->payment_amount,
            'rest_payment_date' => $request->rest_payment_date ? date('Y-m-d', strtotime(str_replace(',', '', $request->rest_payment_date))) : null,
            'deposit' => $request->deposit,
            'reservation_date' => $request->reservation_date ? date('Y-m-d', strtotime(str_replace(',', '', $request->reservation_date))) : null,
            'balance' => $balance,
            'invoice_status' => $invoice_status,
            'referrer_id' => $request->referrer_id ? $request->referrer_id : '',
            'notice' => 0,
            'moved' => 0,
            'paid_balance' => 0,
            'fixed_deposit' => $request->tenants_fixed_deposit ? $request->tenants_fixed_deposit : 0,
            'previous_balance' => $request->tenants_previous_balance ? $request->tenants_previous_balance : 0,
            'created_another_invoice' => 0,
        ]);

        // If card exists
        if ($request->card_id) {
            $card = Card::firstWhere('id', $request->card_id);

            // Change card status
            $card->update([
                'status' => 'active',
            ]);

            // Create a card receipt
            CardReceipt::create([
                'tenant_id' => $request->tenant_id,
                'card_id' => $request->card_id,
                'card_price' => $request->card_price,
                'currency' => $request->currency,
                'receipt_status' => 'issued',
                'issued_date' => $transaction->created_at,
                'from_transaction' => 1,
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'You have successfully created an invoice!');
    }

    // Show Single Invoice
    public function show($id) {
        $settings = Setting::orderBy('invoice_prefix', 'desc')->first();
        $transaction = Transaction::where('id', $id)->first();

        // Get related paybalances for each tenant
        $paybalances = PayBalance::orderBy('created_at', 'desc')->where('invoice_id', $transaction->id)->get();

        return view('operations.invoices.show', compact('transaction', 'settings', 'paybalances'));
    }

    // Edit Invoice
    public function edit($id) {
        $transaction = Transaction::where('id', $id)->first();
        $settings = Setting::orderBy('invoice_prefix', 'desc')->first();
        $buildings = Building::orderBy('name', 'asc')->get();
        $floors = Floor::orderBy('name', 'asc')->get();
        $flats = Flat::orderBy('flat_no', 'asc')->get();
        $partitions = Partition::orderBy('p_number', 'asc')->get();
        $referrers = Referrer::orderBy('name')->get();

        return view('operations.invoices.edit', compact('transaction', 'settings', 'buildings', 'floors', 'flats', 'partitions', 'referrers'));
    }

    // Update Notice of Invoice
    public function updateNotice(Request $request, $id) {
        $request->validate([
            'notice' => 'required'
        ]);

        // Change the invoice's notice status
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'notice' => $request->notice == 1 ? 0 : 1,
        ]);

        // Change the partition status
        $partition = Partition::where('id', $transaction->partition_id)->firstOrFail();
        $partition->update([
            'status' => $transaction->notice == 0 ? 'occupied' : 'notice',
        ]);

        $notice = $transaction->notice == 1 ? 'noticed' : 'unnoticed';

        return redirect()->back()->with('success', 'You have successfully updated the notice status of the transaction ('. $transaction->invoice_prefix . $transaction->invoice_no .') to \''. $notice .'\'!');
    }

    // Update Moved Status of Invoice
    public function updateMoved(Request $request, $id) {
        $request->validate([
            'moved' => 'required',
        ]);

        // Change the invoice's moved status
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'moved' => $request->moved == 0 ? 1 : 0,
        ]);

        // Change the partition status
        $partition = Partition::where('id', $transaction->partition_id)->firstOrFail();
        $partition->update([
            'status' => $transaction->moved == 1 ? 'available' : 'occupied',
        ]);

        // Change the status of tenant
        $tenant = Tenant::where('id', $transaction->tenant_id)->firstOrFail();
        $tenant->update([
            'status' => $transaction->moved == 1 ? 0 : 1,
        ]);

        // Change the card's status if exists
        if ($tenant->cards) {
            foreach($tenant->cards as $card) {
                if ($transaction->moved == 1) {
                    $card->update([
                        'status' => $card->status == 'active' ? 'undefined' : $card->status,
                    ]);
                } else {
                    $card->update([
                        'status' => $card->status == 'undefined' ? 'active' : $card->status,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'You have successfully changed the transaction status to \'moved\'');
    }

    // Update Invoice
    public function update(Request $request, $id) {
        $request->validate([
            'invoice_no' => 'required',
            'tenant_id' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
            'flat_id' => 'required',
            'partition_id' => 'required',
            'price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'sub_total' => 'required',
            'grand_total' => 'required',
        ],
        [
            'tenant_id.required' => 'The passport number & name fields are required.',
            'building_id.required' => 'The building field is required',
            'floor_id.required' => 'The floor field is required',
            'flat_id.required' => 'The flat field is required',
            'partition_id.required' => 'The partition field is required',
        ]);

        $transaction = Transaction::firstWhere('id', $id);

        // Change Tenant Status
        $tenant = Tenant::firstWhere('id', $transaction->tenant_id);
        // Check if tenant's id and request's teant's id are the same
        if ($request->tenant_id == $transaction->tenant_id) {
            // Check if tenant's transactions are greater than zero
            if ($tenant->transactions->count() >= 1) {
                $now = Carbon::now()->toDateString();
                $requested_end_date = date('Y-m-d', strtotime(str_replace(',', '', $request->end_date)));

                // Get unexpired transactions
                $tenantsUnexpiredTransactions = Transaction::where('tenant_id', $tenant->id)->where('end_date', '>', $now)->get();

                if ($requested_end_date > $now) {
                    $tenant->update([
                        'status' => 1,
                    ]);
                } elseif ($requested_end_date > $now && $transaction->end_date > $now) {
                    $tenant->update([
                        'status' => 1,
                    ]);
                } elseif ($requested_end_date < $now && $transaction->end_date > $now) {
                    if ($tenantsUnexpiredTransactions->count() >= 2) {
                        $tenant->update([
                            'status' => 1,
                        ]);
                    } else {
                        $tenant->update([
                            'status' => 0,
                        ]);
                    }
                } elseif ($requested_end_date > $now && $transaction->end_date < $now) {
                    $tenant->update([
                        'status' => 1,
                    ]);
                } else {
                    $tenant->update([
                        'status' => 0,
                    ]);
                }
            }
        } else {
            $tenant->update([
                'status' => 0
            ]);

            $newTenant = Tenant::firstWhere('id', $request->tenant_id);
            $newTenant->update([
                'status' => 1
            ]);
        }

        // Change Partition Status
        if ($transaction->partition_id != $request->partition_id) {
            // Change status of old partition
            $oldPartition = Partition::firstWhere('id', $transaction->partition_id);
            $oldPartition->update([
                'status' => 'available',
            ]);

            // Change status of new partition
            $newPartition = Partition::firstWhere('id', $request->partition_id);
            $newPartition->update([
                'status' => 'occupied'
            ]);
        }

        // Change Card Status
        if ($request->card_id == null && $transaction->card_id) {
            $previousCard = Card::where('id', $transaction->card_id)->first();
            $previousCard->update([
                'status' => 'lost',
            ]);

            $previousCardReceipt = CardReceipt::where('card_id', $previousCard->id)->firstOrFail();
            $previousCardReceipt->update([
                'receipt_status' => 'lost',
            ]);
        } else if ($request->card_id && $transaction->card_id == null) {
            // Change status to 'active' in the new card create a new receipt
            $card = Card::where('id', $request->card_id)->first();
            $card->update([
                'status' => 'active',
            ]);

            // Create a card receipt
            CardReceipt::create([
                'tenant_id' => $transaction->tenant_id,
                'card_id' => $request->card_id,
                'card_price' => $request->card_price,
                'currency' => $request->currency,
                'receipt_status' => 'issued',
                'issued_date' => $transaction->updated_at,
                'from_transaction' => 1,
            ]);
        } else if ($request->card_id && $request->card_id !== $transaction->card_id && $transaction->card_id) {
            // Change status to 'lost' in the previous card and card receipt
            $previousCard = Card::where('id', $transaction->card_id)->firstOrFail();
            $previousCard->update([
                'status' => 'lost',
            ]);

            $previousCardReceipt = CardReceipt::where('card_id', $previousCard->id)->firstOrFail();
            $previousCardReceipt->update([
                'receipt_status' => 'lost',
            ]);

            // Change status to 'active' in the new card create a new receipt
            $card = Card::where('id', $request->card_id)->first();
            $card->update([
                'status' => 'active',
            ]);

            // Create a card receipt
            CardReceipt::create([
                'tenant_id' => $transaction->tenant_id,
                'card_id' => $request->card_id,
                'card_price' => $request->card_price,
                'currency' => $request->currency,
                'receipt_status' => 'issued',
                'issued_date' => $transaction->updated_at,
                'from_transaction' => 1,
            ]);
        }

        // Calculate Balance
        $balance = 0;
        if ($request->payment_amount) {
            $balance = $request->grand_total - $request->payment_amount;
        } else if ($request->deposit) {
            $balance = $request->grand_total - $request->deposit;
        }

        // Invoice Status
        $invoice_status = '';
        if ($balance == 0) {
            $invoice_status = 'fully_paid';
        } else if ($balance > 0) {
            $invoice_status = 'partially_paid';
        }

        // Update Transaction
        $transaction->update([
            'invoice_no' => $transaction->invoice_no,
            'invoice_prefix' => $transaction->invoice_prefix,
            'tenant_id' => $request->tenant_id,
            'invoice_status' => $request->invoice_status,
            'building_id' => $request->building_id,
            'floor_id' => $request->floor_id,
            'flat_id' => $request->flat_id,
            'partition_id' => $request->partition_id,
            'price' => $request->price,
            'start_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->start_date))),
            'end_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->end_date))),
            'card_id' => $request->card_id ? $request->card_id : null,
            'card_price' => $request->card_id ? $request->card_price : null,
            'currency' => $transaction->currency,
            'sub_total' => $request->sub_total,
            'total_price' => $request->grand_total,
            'payment_amount' => $request->payment_amount,
            'rest_payment_date' => $request->rest_payment_date ? date('Y-m-d', strtotime(str_replace(',', '', $request->rest_payment_date))) : null,
            'deposit' => $request->deposit,
            'reservation_date' => $request->reservation_date ? date('Y-m-d', strtotime(str_replace(',', '', $request->reservation_date))) : null,
            'balance' => $balance,
            'invoice_status' => $invoice_status,
            'referrer_id' => $request->referrer_id ? $request->referrer_id : $transaction->referrer_id,
            'fixed_deposit' => $request->tenants_fixed_deposit ? $request->tenants_fixed_deposit : $transaction->fixed_deposit,
            'previous_balance' => $request->tenants_previous_balance ? $request->tenants_previous_balance : $transaction->previous_balance,

        ]);

        return redirect()->back()->with('success', 'You have successfully updated an invoice!');
    }

    // Destroy Invoice
    public function destroy($id) {
        $now = Carbon::now()->toDateString();
        $transaction = Transaction::where('id', $id)->first();

        // Change Tenant Status
        $tenant = Tenant::firstWhere('id', $transaction->tenant_id);

        if ($tenant->transactions->count() >= 1) {
            // Get unexpired transactions
            $tenantsUnexpiredTransactions = Transaction::where('tenant_id', $tenant->id)->where('end_date', '>', $now)->get();

            if ($tenantsUnexpiredTransactions->count() >= 2) {
                $tenant->update([
                    'status' => 1,
                ]);
            } else {
                $tenant->update([
                    'status' => 0,
                ]);
            }
        }

        // Change Partition Status
        $partition = Partition::firstWhere('id', $transaction->partition_id);
        $partition->update([
            'status' => 'available',
        ]);

        // Change Card Status
        if ($transaction->card_id) {
            $card = Card::where('id', $transaction->card_id)->first();
            $card->update([
                'status' => 'lost',
            ]);
        }

        // Check pay balances exist and delete if so
        if ($transaction->paybalances->count() > 0) {
            $transaction->paybalances->map(function($paybalance) {
                $paybalance->delete();
            });
        }

        $transaction->delete();

        return redirect()->back()->with('success', 'You have successfully deleted an invoice!');
    }

    // Export as excel
    public function export(Request $request) {
        $fetchedDaysDate = Carbon::now()->subDays($request->days)->toDateTimeString();
        $parsedDaysDate = Carbon::parse($fetchedDaysDate);
        $requestedDays = $parsedDaysDate->diffInDays(Carbon::now());

        if ($request->days == 0) {
            $download_file_name = 'today-transactions.xlsx';
        } else if ($request->days == 1) {
            $download_file_name = 'yesterday-transactions.xlsx';
        } else if ($request->days == 7) {
            $download_file_name = 'last-7-days-transactions.xlsx';
        } else if ($request->days == 15) {
            $download_file_name = 'last-15-days-transactions.xlsx';
        } else if ($request->days == 30) {
            $download_file_name = 'last-30-days-transactions.xlsx';
        }

        return (new TransactionsExport($requestedDays))->download($download_file_name);
    }
}
