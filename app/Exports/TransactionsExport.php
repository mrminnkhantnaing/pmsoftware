<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Transaction;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

use function PHPSTORM_META\map;

class TransactionsExport implements WithHeadings, WithMapping, ShouldAutoSize, FromQuery, WithStyles, WithStrictNullComparison, WithEvents
{
    use Exportable;

    public function __construct(int $days)
    {
        $this->days = $days;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function query()
    {
        return Transaction::query()
        ->with('building', 'floor', 'flat', 'partition', 'tenant', 'card')
        ->whereDate('created_at', '>=', Carbon::now()->subDays($this->days))
        ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Date',
            'Invoice No.',
            'Invoice Type',
            'Tenant Name',
            'Partition No.',
            'Flat No.',
            'Floor Name',
            'Building Name',
            'Price',
            // 'Sub Total',
            'Card Price',
            'Grand Total',
            'Paid Amount',
            'Balance',
            'Start Date',
            'End Date',
        ];
    }

    /**
     * @return array
     */

    /**
    * @var Transaction $transaction
    */
    public function map($transaction): array
    {
        return [
            date('d M, Y', strtotime($transaction->created_at)),
            $transaction->invoice_prefix . $transaction->invoice_no,
            $transaction->invoice_type == 'payment' ? 'Payment' : 'Reservation',
            $transaction->tenant->name,
            $transaction->partition->p_number,
            $transaction->flat->flat_no,
            $transaction->floor->name,
            $transaction->building->name,
            number_format($transaction->price, 0, '.', ','),
            // number_format($transaction->sub_total, 0, '.', ','),
            $transaction->card_price ? number_format($transaction->card_price, 0, '.', ',') : 0,
            number_format($transaction->total_price, 0, '.', ','),
            $transaction->payment_amount ? number_format($transaction->payment_amount, 0, '.', ',') : number_format($transaction->deposit, 0, '.', ','),
            number_format($transaction->balance, 0, '.', ','),
            date('d M, Y', strtotime($transaction->start_date)),
            date('d M, Y', strtotime($transaction->end_date)),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // $cellRange = 'A2:O2'; // All headers
                // $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $transactions = Transaction::query()
                ->with('building', 'floor', 'flat', 'partition', 'tenant', 'card')
                ->whereDate('created_at', '>=', Carbon::now()->subDays($this->days))
                ->orderBy('created_at', 'desc');

                $sum_of_price = $transactions->pluck('price')->sum();
                // $sum_of_sub_total = $transactions->pluck('sub_total')->sum();
                $sum_of_card_price = $transactions->pluck('card_price')->sum();
                $sum_of_total_price = $transactions->pluck('total_price')->sum();
                $sum_of_balance = $transactions->pluck('balance')->sum();

                $event->sheet->appendRows([
                    ['Total',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    number_format($sum_of_price, 0, '.', ','),
                    // $sum_of_sub_total,
                    number_format($sum_of_card_price, 0, '.', ','),
                    number_format($sum_of_total_price, 0, '.', ','),
                    number_format($sum_of_total_price - $sum_of_balance, 0, '.', ','),
                    number_format($sum_of_balance, 0, '.', ','),
                    '',
                    '',]
                ], $event);
            },
        ];
    }
}
