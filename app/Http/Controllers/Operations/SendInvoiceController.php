<?php

namespace App\Http\Controllers\Operations;

use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Mail\TransactionProcessed;
use App\Http\Controllers\Controller;
use App\Mail\ReceiptProcessed;
use App\Models\CardReceipt;
use Illuminate\Support\Facades\Mail;

class SendInvoiceController extends Controller
{
    // Send email for daily reports
    public function sendDailyReports() {

    }

    // Send Invoice Email
    public function sendInvoice($id) {
        $transaction = Transaction::findOrFail($id);
        $settings = Setting::where('id', 1)->first();

        if ($transaction->tenant->email) {
            Mail::to($transaction->tenant)
            ->queue(new TransactionProcessed($transaction, $settings));

            return redirect()->route('invoices.show', $id)->with('success', 'Email has been successfully sent to '. $transaction->tenant->email .'!');
        } else {
            return redirect()->route('invoices.show', $id)->with('error', 'Email field for '. $transaction->tenant->name .' is empty, please update the email address of the tenant first!');
        }

    }

    // Send Receipt Email
    public function sendReceipt($id) {
        $cardReceipt = CardReceipt::findOrFail($id);
        $settings = Setting::where('id', 1)->first();

        if ($cardReceipt->tenant->email) {
            Mail::to($cardReceipt->tenant)->send(new ReceiptProcessed($cardReceipt, $settings));

            return redirect()->route('invoices.cards.index')->with('success', 'Email has been successfully sent to the tenant!');
        } else {
            return redirect()->route('invoices.cards.index')->with('error', 'Email field for this tenant is empty, please update the email address of this tenant first!');
        }
    }
}
