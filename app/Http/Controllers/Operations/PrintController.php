<?php

namespace App\Http\Controllers\Operations;

use App\Models\Invoice;
use App\Models\Setting;
use App\Models\CardReceipt;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BedspaceTransaction;
use App\Http\Controllers\Controller;
use App\Models\PayBalance;

class PrintController extends Controller
{
    // Print Transactional Invoices
    public function printInvoices($id) {
        $settings = Setting::firstWhere('id', 1);
        $transaction = Transaction::firstWhere('id', $id);

        return view('prints.invoice', compact('settings', 'transaction'));
    }

    // Print PayBalance
    public function printPayBalance($id) {
        $settings = Setting::firstWhere('id', 1);
        $paybalance = PayBalance::firstWhere('id', $id);
        $transaction = Transaction::firstWhere('id', $paybalance->invoice_id);

        return view('prints.paybalance', compact('settings', 'paybalance', 'transaction'));
    }

    // Print Card Receipts
    public function printCardReceipts($receipt_id) {
        $settings = Setting::firstWhere('id', 1);
        $cardReceipt = CardReceipt::firstWhere('id', $receipt_id);
        $transaction = Transaction::where('tenant_id', $cardReceipt->tenant_id)->orderBy('created_at', 'desc')->first();

        return view('prints.card-receipt', compact('settings', 'cardReceipt', 'transaction'));
    }
}
