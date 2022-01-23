<?php

namespace App\Mail;

use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade as PDF;

class TransactionProcessed extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction, $settings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, Setting $settings)
    {
        $this->transaction = $transaction;
        $this->settings = $settings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('emails.transactions.completed-pdf', ['settings' => $this->settings, 'transaction' => $this->transaction]);

        return $this->subject($this->transaction->invoice_prefix . $this->transaction->invoice_no . ' - Invoice From ' . $this->settings->company_name)
                    ->view('emails.transactions.completed')
                    ->attachData($pdf->output(), $this->transaction->invoice_no . '.pdf', [
                        'mime' => 'application/pdf'
                    ]);;
    }
}
