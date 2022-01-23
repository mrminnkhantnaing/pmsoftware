<?php

namespace App\Http\Controllers\Operations;

use App\Models\Flat;
use App\Models\Floor;
use App\Models\Partition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bedspace;
use App\Models\Card;
use App\Models\PayBalance;
use App\Models\Setting;
use App\Models\Tenant;
use App\Models\Transaction;

class AjaxController extends Controller
{
    // selectFloorsFromBuilding
    public function selectFloorsFromBuilding($building_id) {
        $floors = Floor::where('building_id', $building_id)->orderBy('name', 'asc')->get();

        return json_encode($floors);
    }

    // selectFlatsFromFloor
    public function selectFlatsFromFloor($floor_id) {
        $flats = Flat::where('floor_id', $floor_id)->orderBy('flat_no', 'asc')->get();

        return json_encode($flats);
    }

    // selectPartitionsFromFlat
    public function selectPartitionsFromFlat($flat_id) {
        $partitions = Partition::where('flat_id', $flat_id)->get();

        return json_encode($partitions);
    }

    // selectTenantFromIdOrPassport
    public function selectTenantFromIdOrPassport($idorpassport) {
        $tenant = Tenant::with('transaction', 'transaction.floor', 'transaction.flat', 'transaction.partition')->where('idorpassport', $idorpassport)->first();

        if (!$tenant) {
            return;
        }

        return json_encode($tenant);
    }

    // selectCardFromCode
    public function selectCardFromCode($code) {
        $card = Card::where('code', $code)->first();

        if (!$card) {
            return;
        }

        return json_encode($card);
    }

    // fetchSettings
    public function fetchSettings() {
        $settings = Setting::findOrFail(1);

        return json_encode($settings);
    }

    // selectInvoiceFromInvoiceNumber
    public function selectInvoiceFromInvoiceNumber($invoice_no) {
        $invoice_prefix = substr($invoice_no, 0, 2);
        $invoice_number = substr($invoice_no, 2, 10);

        $invoice = Transaction::with('tenant', 'building', 'floor', 'flat', 'partition', 'card', 'referrer', 'paybalances')
                    ->where([
                        ['invoice_prefix', '=', $invoice_prefix],
                        ['invoice_no', '=', $invoice_number],
                    ])
                    ->firstOrFail();

        $paybalance = PayBalance::where('invoice_id', $invoice->id)->first();
        if ($paybalance && $paybalance->balance == 0) {
            return abort(403);
        }

        if ($invoice && $invoice->balance == 0) {
            return abort(403);
        }

        return json_encode($invoice);
    }
}
