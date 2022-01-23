<?php

namespace App\Http\Controllers\Operations;

use App\Exports\CardReceiptsExport;
use Carbon\Carbon;
use App\Models\Card;
use App\Models\Setting;
use App\Models\CardReceipt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CardReceiptController extends Controller
{
    // Show All Card Receipts
    public function index() {
        $cardReceipts = Cache::remember('card-receipts-index', now()->addDay(), function() {
            return CardReceipt::orderBy('id', 'desc')->get();
        });

        $settings = Setting::where('id', 1)->first();

        return view('operations.card-receipts.index', compact('cardReceipts', 'settings'));
    }

    // Create Card Receipt
    public function create() {
        $settings = Setting::where('id', 1)->first();

        return view('operations.card-receipts.create', compact('settings'));
    }

    // Store Card Receipt
    public function store(Request $request) {
        $request->validate([
            'tenant_id' => 'required',
            'card_id' => 'required',
            'issued_date' => 'required',
        ],
        [
            'card_id.required' => 'The card id field is required.',
            'tenant_id.required' => 'The tenant field is required.',
        ]);

        CardReceipt::create([
            'tenant_id' => $request->tenant_id,
            'card_id' => $request->card_id,
            'card_price' => $request->card_price,
            'currency' => $request->currency,
            'receipt_status' => 'issued',
            'issued_date' => date('Y-m-d', strtotime(str_replace(',', '', $request->issued_date))),
            'from_transaction' => 0,
        ]);

        // Check Card & Update
        $card = Card::where('id', $request->card_id)->first();

        if ($card->status != 'available') {
            return redirect()->back()->with('error', 'Please add an available card id!');
        } else if ($request->tenant_id == null) {
            return redirect()->back()->with('error', 'Please add an existing tenant or create a new tenant!');
        } else {
            $card->update([
                'status' => 'active',
            ]);
        }


        return redirect()->route('invoices.cards.index')->with('success', 'You have successfully created a card receipt!');
    }

    // Update Card Receipt
    public function update(Request $request, $id) {
        $cardReceipt = CardReceipt::where('id', $id)->first();

        // Update Card Receipt
        $cardReceipt->update([
            'receipt_status' => $request->receipt_status,
            'returned_date' => $request->returned_date ? date('Y-m-d', strtotime(str_replace(',', '', $request->returned_date))) : null,
        ]);

        // Check Card & Update
        $card = Card::where('id', $cardReceipt->card_id)->first();
        if ($cardReceipt->receipt_status == 'issued') {
            $card->update([
                'status' => 'active',
            ]);
        } else if ($cardReceipt->receipt_status == 'returned') {
            $card->update([
                'status' => 'available',
            ]);
        } else if ($cardReceipt->receipt_status == 'lost') {
            $card->update([
                'status' => 'lost',
            ]);
        }

        return redirect()->route('invoices.cards.index')->with('success', 'You have successfully updated a card receipt!');
    }

    // Destroy Card Receipt
    public function destroy($id) {
        $cardReceipt = CardReceipt::where('id', $id)->first();

        // Check Card & Update
        $card = Card::where('id', $cardReceipt->card_id)->first();
        if ($cardReceipt->receipt_status == 'issued' || $cardReceipt->receipt_status == 'returned') {
            $card->update([
                'status' => 'available',
            ]);
        } else if ($cardReceipt->receipt_status == 'lost') {
            $card->update([
                'status' => 'lost',
            ]);
        }

        $cardReceipt->delete();

        return redirect()->route('invoices.cards.index')->with('success', 'You have successfully deleted a card receipt!');
    }

    // Export as excel
    public function export(Request $request) {
        $fetchedDaysDate = Carbon::now()->subDays($request->days)->toDateTimeString();
        $parsedDaysDate = Carbon::parse($fetchedDaysDate);
        $requestedDays = $parsedDaysDate->diffInDays(Carbon::now());

        if ($request->days == 0) {
            $download_file_name = 'today-card-receipts.xlsx';
        } else if ($request->days == 1) {
            $download_file_name = 'yesterday-card-receipts.xlsx';
        } else if ($request->days == 7) {
            $download_file_name = 'last-7-days-card-receipts.xlsx';
        } else if ($request->days == 15) {
            $download_file_name = 'last-15-days-card-receipts.xlsx';
        } else if ($request->days == 30) {
            $download_file_name = 'last-30-days-card-receipts.xlsx';
        }

        return (new CardReceiptsExport($requestedDays))->download($download_file_name);
    }
}
