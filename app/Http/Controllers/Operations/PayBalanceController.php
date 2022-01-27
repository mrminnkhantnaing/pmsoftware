<?php

namespace App\Http\Controllers\Operations;

use App\Exports\PayBalancesExport;
use Carbon\Carbon;
use App\Models\Card;
use App\Models\Setting;
use App\Models\PayBalance;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PayBalanceController extends Controller
{
    // Show All PayBalances
    public function index() {
        $paybalances = Cache::remember('paybalances-index', now()->addDay(), function() {
            return PayBalance::with('invoice', 'tenant', 'building', 'floor', 'flat', 'partition', 'partition.building', 'partition.floor', 'partition.flat')->orderBy('created_at', 'desc')->get();
        });

        return view('operations.pay-balance.index', compact('paybalances'));
    }

    // Create PayBalance
    public function create() {
        $settings = Setting::firstWhere('id', 1);

        return view('operations.pay-balance.create', compact('settings'));
    }

    // Store PayBalance
    public function store(Request $request) {
        $request->validate([
            'invoice_id' => 'required|integer|min:0',
            'no_of_tenant' => 'required|integer|min:0',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required|integer|min:0',
            'sub_total' => 'required|integer|min:0',
            'grand_total' => 'required|integer|min:0',
            'initial_payment_amount' => 'required|integer|min:0',
            'current_payment_amount' => 'required|integer|min:0',
            'balance' => 'required|integer|min:0',
        ]);

        $transaction = Transaction::firstWhere('id', $request->invoice_id);

        // Change Card Status
        if ($request->card_id && $transaction->card_id && $request->card_id != $transaction->card_id) {
            // Change status to 'available' in the previous card
            $previousCard = Card::firstWhere('id', $transaction->card_id);
            $previousCard->update([
                'status' => 'available',
            ]);

            // Change status to 'active' in the new card
            $currentCard = Card::firstWhere('id', $request->card_id);
            $currentCard->update([
                'status' => 'active',
            ]);

            // Update card id in transaction
            $transaction->update([
                'card_id' => $currentCard->id,
                'card_price' => $request->card_price,
            ]);
        } else if ($request->card_id && $transaction->card_id == null) {
            // Change status to 'active' in the new card
            $card = Card::where('id', $request->card_id)->first();
            $card->update([
                'status' => 'active',
            ]);

            // Update card id in transaction
            $transaction->update([
                'card_id' => $card->id,
                'card_price' => $request->card_price,
            ]);
        }

        // Change paid_balance in transaction if paybalance's balance is zero
        if ($request->balance == 0) {
            $transaction->update([
                'paid_balance' => 1
            ]);
        }

        // Update transaction's start and end dates
        $transaction->update([
            'start_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->start_date))),
            'end_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->end_date))),
        ]);

        // Activate The Reservation
        if ($transaction->invoice_type == 'reservation') {
            $transaction->update([
                'reservation_activated' => 1,
            ]);
        }

        PayBalance::create([
            'invoice_id' => $request->invoice_id,
            'invoice_status' => $request->balance == 0 ? 'fully_paid' : 'partially_paid',
            'invoice_type' => strtolower($request->invoice_type),
            'no_of_tenant' => $request->no_of_tenant,
            'tenant_id' => $request->tenant_id,
            'building_id' => $request->ibuilding_id,
            'floor_id' => $request->ifloor_id,
            'flat_id' => $request->iflat_id,
            'partition_id' => $request->ipartition_id,
            'card_id' => $request->card_id ?? $request->card_id,
            'card_price' => $request->card_id ? $request->card_price : null,
            'currency' => $request->currency,
            'start_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->start_date))),
            'end_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->end_date))),
            'price' => $request->price,
            'sub_total' => $request->sub_total,
            'total_price' => $request->grand_total,
            'initial_payment_amount' => $request->initial_payment_amount,
            'current_payment_amount' => $request->current_payment_amount,
            'balance' => $request->balance,
        ]);

        return redirect()->route('invoices.balance.index')->with('success', 'You have successfully created a pay balance!');
    }

    // Show Single PayBalance
    public function show($id) {
        $paybalance = PayBalance::with('invoice', 'tenant')->where('id', $id)->firstOrFail();
        $settings = Setting::where('id', 1)->firstOrFail();

        $transaction = Transaction::where('id', $paybalance->invoice_id)->first();

        // $previousPayBalanceAmount = $transaction->paybalances->map(function($paybalance) {
        //     return $paybalance->current_payment_amount;
        // })->sum();

        // $previousPayBalanceAmount = 0;
        // foreach ($transaction->paybalances as $paybalance) {
        //     $previousPayBalanceAmount += $paybalance->current_payment_amount;
        // }

        $previousPayBalanceAmount = $transaction->paybalances->pluck('current_payment_amount')->sum();

        return view('operations.pay-balance.show', compact('paybalance', 'transaction', 'settings', 'previousPayBalanceAmount'));
    }

    // Edit PayBalance
    public function edit($id) {
        $paybalance = PayBalance::findOrFail($id);
        $transaction = Transaction::where('id', $paybalance->invoice_id)->first();
        $settings = Setting::where('id', 1)->first();

        return view('operations.pay-balance.edit', compact('paybalance', 'transaction', 'settings'));
    }

    // Update PayBalance
    public function update(Request $request, $id) {
        $request->validate([
            'invoice_id' => 'required|integer|min:0',
            'no_of_tenant' => 'required|integer|min:0',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required|integer|min:0',
            'sub_total' => 'required|integer|min:0',
            'grand_total' => 'required|integer|min:0',
            'initial_payment_amount' => 'required|integer|min:0',
            'current_payment_amount' => 'required|integer|min:0',
            'balance' => 'required|integer|min:0',
        ]);

        $paybalance = PayBalance::findOrFail($id);
        $transaction = Transaction::where('id', $request->invoice_id)->firstOrFail();

        // Change Card Status
        if ($request->card_id && $paybalance->card_id && $paybalance->card_id != $request->card_id) {
            // Change status to 'available' in the previous card
            $previousCard = Card::firstWhere('id', $paybalance->card_id);
            $previousCard->update([
                'status' => 'available',
            ]);

            // Change status to 'active' in the new card
            $currentCard = Card::firstWhere('id', $request->card_id);
            $currentCard->update([
                'status' => 'active',
            ]);

            // Update card id in transaction
            $transaction->update([
                'card_id' => $currentCard->id,
                'card_price' => $request->card_price,
            ]);
        } else if ($request->card_id && $paybalance->card_id == null) {
            // Change status to 'active' in the new card
            $card = Card::firstWhere('id', $request->card_id);
            $card->update([
                'status' => 'active',
            ]);

            $transaction->update([
                'card_id' => $card->id,
                'card_price' => $request->card_price,
            ]);
        }

        // Change paid_balance in transaction if paybalance's balance is zero
        if ($request->balance == 0) {
            $transaction->update([
                'paid_balance' => 1
            ]);
        }

        // Update transaction's start and end dates
        $transaction->update([
            'start_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->start_date))),
            'end_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->end_date))),
        ]);

        $paybalance->update([
            'invoice_id' => $request->invoice_id,
            'invoice_status' => $request->balance == 0 ? 'fully_paid' : 'partially_paid',
            'invoice_type' => strtolower($request->invoice_type),
            'no_of_tenant' => $request->no_of_tenant,
            'tenant_id' => $request->tenant_id,
            'building_id' => $request->ibuilding_id,
            'floor_id' => $request->ifloor_id,
            'flat_id' => $request->iflat_id,
            'partition_id' => $request->ipartition_id,
            'card_id' => $request->card_id ?? $request->card_id,
            'card_price' => $request->card_id ? $request->card_price : null,
            'currency' => $request->currency,
            'start_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->start_date))),
            'end_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->end_date))),
            'price' => $request->price,
            'sub_total' => $request->sub_total,
            'total_price' => $request->grand_total,
            'initial_payment_amount' => $request->initial_payment_amount,
            'current_payment_amount' => $request->current_payment_amount,
            'balance' => $request->balance,
        ]);

        return redirect()->route('invoices.balance.index')->with('success', 'You have successfully updated a pay balance!');
    }

    // Destroy PayBalance
    public function destroy($id) {
        $paybalance = PayBalance::findOrFail($id);

        if ($paybalance->card_id) {
            $card = Card::where('id', $paybalance->card_id)->first();
            $card->update([
                'status' => 'lost',
            ]);
        }

        if ($paybalance->balance == 0) {
            $transaction = Transaction::firstWhere('id', $paybalance->invoice_id);
            $transaction->update([
                'paid_balance' => 0
            ]);
        }

        $paybalance->delete();

        return redirect()->route('invoices.balance.index')->with('success', 'You have successfully deleted a pay balance!');
    }

    // Export as excel
    public function export(Request $request) {
        $fetchedDaysDate = Carbon::now()->subDays($request->days)->toDateTimeString();
        $parsedDaysDate = Carbon::parse($fetchedDaysDate);
        $requestedDays = $parsedDaysDate->diffInDays(Carbon::now());

        if ($request->days == 0) {
            $download_file_name = 'today-paybalances.xlsx';
        } else if ($request->days == 1) {
            $download_file_name = 'yesterday-paybalances.xlsx';
        } else if ($request->days == 7) {
            $download_file_name = 'last-7-days-paybalances.xlsx';
        } else if ($request->days == 15) {
            $download_file_name = 'last-15-days-paybalances.xlsx';
        } else if ($request->days == 30) {
            $download_file_name = 'last-30-days-paybalances.xlsx';
        }

        return (new PayBalancesExport($requestedDays))->download($download_file_name);
    }
}
