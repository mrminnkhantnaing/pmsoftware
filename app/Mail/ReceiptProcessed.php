<?php

namespace App\Mail;

use App\Models\CardReceipt;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade as PDF;

class ReceiptProcessed extends Mailable
{
    use Queueable, SerializesModels;

    public $cardReceipt;
    public $settings;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CardReceipt $cardReceipt, Setting $settings)
    {
        $this->cardReceipt = $cardReceipt;
        $this->settings = $settings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('emails.card-receipts.completed-pdf', ['settings' => $this->settings, 'cardReceipt' => $this->cardReceipt]);

        return $this->subject($this->cardReceipt->card->code . ' - Card Receipt From ' . $this->settings->company_name)
                    ->view('emails.card-receipts.completed')
                    ->attachData($pdf->output(), $this->cardReceipt->card->code . '.pdf', [
                        'mime' => 'application/pdf'
                    ]);
    }
}
