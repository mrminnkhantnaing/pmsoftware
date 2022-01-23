<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\CardReceipt;
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

class CardReceiptsExport implements WithHeadings, WithMapping, ShouldAutoSize, FromQuery, WithStyles, WithStrictNullComparison, WithEvents
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
        return CardReceipt::query()
        ->with('tenant', 'card')
        ->whereDate('created_at', '>=', Carbon::now()->subDays($this->days))
        ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Date',
            'Tenant Name',
            'ID/Passport',
            'Card ID',
            'Card Price',
            'Paid Amount',
            'Balance',
            'Issued Date',
            'Returned Date',
            'From Transaction',
        ];
    }

    /**
     * @return array
     */

    /**
    * @var CardReceipt $cardreceipt
    */
    public function map($cardreceipt): array
    {
        return [
            date('d M, Y', strtotime($cardreceipt->created_at)),
            $cardreceipt->tenant->name,
            $cardreceipt->tenant->idorpassport,
            $cardreceipt->card->code,
            number_format($cardreceipt->card_price, 0, '.', ','),
            number_format($cardreceipt->card_price, 0, '.', ','),
            0,
            date('d M, Y', strtotime($cardreceipt->issued_date)),
            $cardreceipt->returned_date ? date('d M, Y', strtotime($cardreceipt->returned_date)) : '',
            $cardreceipt->from_transaction == 1 ? 'Yes' : 'No',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cardreceipts = CardReceipt::query()
                ->whereDate('created_at', '>=', Carbon::now()->subDays($this->days))
                ->orderBy('created_at', 'desc');

                $sum_of_card_price = $cardreceipts->where('from_transaction', 0)->pluck('card_price')->sum();

                $event->sheet->appendRows([
                    ['Total',
                    '',
                    '',
                    '',
                    number_format($sum_of_card_price, 0, '.', ','),
                    number_format($sum_of_card_price, 0, '.', ','),
                    0,
                    '',
                    '',
                    '']
                ], $event);
            },
        ];
    }
}
