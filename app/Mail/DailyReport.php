<?php

namespace App\Mail;

use App\Exports\CardReceiptsExport;
use App\Exports\PayBalancesExport;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $requestedDays = 0;
        $transactionExcelName = 'transaction-reports-' . date('d-m-Y') . '.xlsx';
        $paybalanceExcelName = 'pay-balance-reports-' . date('d-m-Y') . '.xlsx';
        $cardreceiptExcelName = 'card-receipt-reports-' . date('d-m-Y') . '.xlsx';

        $attachment1 = Excel::raw(new TransactionsExport($requestedDays), \Maatwebsite\Excel\Excel::XLSX);
        $attachment2 = Excel::raw(new PayBalancesExport($requestedDays), \Maatwebsite\Excel\Excel::XLSX);
        $attachment3 = Excel::raw(new CardReceiptsExport($requestedDays), \Maatwebsite\Excel\Excel::XLSX);

        $settings = Setting::query()
                    ->where('id', 1)
                    ->first();

        return $this->subject('Daily Reports for PM Software (' . date('d M, Y') . ') - ' . $settings->company_name . '')
                    ->view('emails.reports.daily-report')
                    ->attachData(
                        $attachment1, $transactionExcelName)
                    ->attachData(
                        $attachment2, $paybalanceExcelName)
                    ->attachData(
                        $attachment3, $cardreceiptExcelName);
    }
}
