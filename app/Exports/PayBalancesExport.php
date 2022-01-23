<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\PayBalance;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PayBalancesExport implements WithHeadings, WithMapping, ShouldAutoSize, FromQuery, WithStyles, WithStrictNullComparison, WithEvents
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
        return PayBalance::query()
        ->with('invoice', 'building', 'floor', 'flat', 'partition', 'tenant', 'card')
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
            'Building Name',
            'Floor Name',
            'Flat No.',
            'Partition No.',
            'Price',
            // 'Sub Total',
            'Card Price',
            'Grand Total',
            'Initial Paid Amount',
            'Current Paid Amount',
            'Balance',
            'Start Date',
            'End Date',
        ];
    }

    /**
     * @return array
     */

    /**
    * @var PayBalance $paybalance
    */
    public function map($paybalance): array
    {
        return [
            date('d M, Y', strtotime($paybalance->created_at)),
            $paybalance->invoice->invoice_prefix . $paybalance->invoice->invoice_no,
            $paybalance->invoice_type == 'payment' ? 'Payment' : 'Reservation',
            $paybalance->tenant->name,
            $paybalance->building->name,
            $paybalance->floor->name,
            $paybalance->flat->flat_no,
            'Partition ' . $paybalance->partition->p_number,
            number_format($paybalance->price, 0, '.', ','),
            // number_format($paybalance->sub_total, 0, '.', ','),
            $paybalance->card_price ? number_format($paybalance->card_price, 0, '.', ',') : 0,
            number_format($paybalance->total_price, 0, '.', ','),
            number_format($paybalance->initial_payment_amount, 0, '.', ','),
            number_format($paybalance->current_payment_amount, 0, '.', ','),
            number_format($paybalance->balance, 0, '.', ','),
            date('d M, Y', strtotime($paybalance->start_date)),
            date('d M, Y', strtotime($paybalance->end_date)),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // $cellRange = 'A2:O2'; // All headers
                // $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $paybalances = PayBalance::query()
                ->with('building', 'floor', 'flat', 'partition', 'tenant', 'card')
                ->whereDate('created_at', '>=', Carbon::now()->subDays($this->days))
                ->orderBy('created_at', 'desc');

                $sum_of_price = $paybalances->pluck('price')->sum();
                // $sum_of_sub_total = $paybalances->pluck('sub_total')->sum();
                $sum_of_card_price = $paybalances->pluck('card_price')->sum();
                $sum_of_initial_payment_amount = $paybalances->pluck('initial_payment_amount')->sum();
                $sum_of_current_payment_amount = $paybalances->pluck('current_payment_amount')->sum();
                $sum_of_total_price = $paybalances->pluck('total_price')->sum();
                $sum_of_balance = $paybalances->pluck('balance')->sum();

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
                    number_format($sum_of_initial_payment_amount, 0, '.', ','),
                    number_format($sum_of_current_payment_amount, 0, '.', ','),
                    number_format($sum_of_balance, 0, '.', ','),
                    '',
                    '',]
                ], $event);
            },
        ];
    }
}
