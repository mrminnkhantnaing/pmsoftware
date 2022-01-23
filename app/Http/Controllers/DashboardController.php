<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Floor;
use App\Models\Tenant;
use App\Models\Setting;
use App\Models\Building;
use App\Models\Partition;
use App\Models\CardReceipt;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FixedDeposit;
use App\Models\Flat;
use App\Models\PayBalance;

class DashboardController extends Controller
{
    // Dashboard
    public function index() {
        $settings = Setting::firstWhere('id', 1);
        $buildingsCount = Building::count();
        $floorsCount = Floor::count();
        $flatsCount = Flat::count();
        $tenantsCount = Tenant::count();
        $newTenantsWithin1Month = Tenant::where('created_at', '>', Carbon::now()->subDays(30))->count();

        // Get Recent Transactions - Last 6
        $recentTransactions = Transaction::with('building', 'floor', 'flat', 'partition', 'tenant')->latest()->limit(6)->get();

        // Get Recent Card Receipts - Last 6
        $recentCardReceipts = CardReceipt::with('tenant', 'card')->latest()->limit(6)->get();

        // Get Recent PayBalance - Last 6
        $recentPaybalances = PayBalance::with('invoice', 'building', 'floor', 'flat', 'partition', 'tenant')->latest()->limit(6)->get();

        // Get New Tenants - Last 6
        $newTenants = Tenant::with('country')->latest()->limit(6)->get();

        // Get Total Amount Of Invoice For The Last 30 Days
        $allTransactions = Transaction::whereDate('created_at', '>', Carbon::now()->subDays(30)->toDateTimeString())->get();
        $allCardReceipts = CardReceipt::whereDate('created_at', '>', Carbon::now()->subDays(30)->toDateTimeString())->get();

        $cardTotalPrice = 0;
        foreach ($allCardReceipts as $cardReceipt) {
            $cardTotalPrice += $cardReceipt->card_price;
        }

        $subTotalOfTransactions = 0;
        foreach ($allTransactions as $transaction) {
            $subTotalOfTransactions += $transaction->sub_total;
        }

        $totalAmountOfTransactions = $subTotalOfTransactions + $cardTotalPrice;

        // Get Invoices To Be Paid Within 7 Days
        $invoices = Transaction::whereDate('end_date', '<=', Carbon::now()->addDays(7)->toDateTimeString())
                                ->whereDate('end_date', '>=', Carbon::now()->toDateTimeString())
                                ->where('created_another_invoice', 0)
                                ->where('notice', 0)
                                ->where('moved', 0)
                                ->get();

        // Get Dued Invoices
        $duedInvoices = Transaction::whereDate('end_date', '<', Carbon::now()->toDateTimeString())
                                    ->where('created_another_invoice', 0)
                                    ->where('notice', 0)->where('moved', 0)->get();

        // Get All Available Partitions
        $availablePartitionsCount = Partition::where('status', 'available')->count();

        // Get All Partitions On Notice
        $partitionsOnNoticeCount = Partition::where('status', 'notice')->count();

        // Get Available Cards
        $availableCardsCount = Card::where('status', 'available')->count();

        // Get Todays' Transactions
        $todaysTransactionsCount = Transaction::whereDate('created_at', '=', now())->count();
        $todaysPaybalancesCount = PayBalance::whereDate('created_at', '=', now())->count();
        $todaysCardreceiptsCount = CardReceipt::whereDate('created_at', '=', now())->where('from_transaction', 0)->count();
        $todaysInvoicesCount = $todaysTransactionsCount + $todaysPaybalancesCount + $todaysCardreceiptsCount;

        // Get Balances To Receive
        $balancesToReceiveCount = Transaction::where('balance', '>', 0)->where('paid_balance', 0)->count();

        // Total Fixed Deposit Amount
        $totalFixedDepositAmount = FixedDeposit::pluck('deposit_amount')->sum();

        return view('dashboard', compact('settings', 'buildingsCount', 'floorsCount', 'flatsCount', 'tenantsCount', 'availablePartitionsCount', 'newTenantsWithin1Month', 'recentTransactions', 'recentCardReceipts', 'newTenants', 'totalAmountOfTransactions', 'availableCardsCount', 'partitionsOnNoticeCount', 'invoices', 'duedInvoices', 'todaysInvoicesCount', 'balancesToReceiveCount', 'recentPaybalances', 'totalFixedDepositAmount'));
    }

    // invoicesToBePaidWithin7Days
    public function invoicesToBePaidWithin7Days() {
        $transactions = Transaction::whereDate('end_date', '<=', Carbon::now()->addDays(7)->toDateTimeString())
                        ->whereDate('end_date', '>=', Carbon::now()->toDateTimeString())
                        ->where('created_another_invoice', 0)
                        ->where('notice', 0)
                        ->where('moved', 0)
                        ->orderBy('invoice_no', 'desc')
                        ->get();

        return view('pages.dashboard.invoices-to-be-paid-within-7-days', compact('transactions'));
    }

    // duedInvoices
    public function duedInvoices() {
        $transactions = Transaction::whereDate('end_date', '<', Carbon::now()->toDateTimeString())
                        ->where('created_another_invoice', 0)
                        ->where('notice', 0)
                        ->where('moved', 0)
                        ->orderBy('invoice_no', 'desc')
                        ->get();

        return view('pages.dashboard.dued-invoices', compact('transactions'));
    }

    // New Tenants
    public function newTenants() {
        $newTenants = Tenant::whereDate('created_at', '>', Carbon::now()->subDays(30)->toDateTimeString())->get();

        return view('pages.dashboard.new-tenants', compact('newTenants'));
    }

    // availablePartitions
    public function availablePartitions() {
        $partitions = Partition::where('status', 'available')->get();

        return view('pages.dashboard.available-partitions', compact('partitions'));
    }

    // partitionsOnNotice
    public function partitionsOnNotice() {
        $partitions = Partition::where('status', 'notice')->get();

        return view('pages.dashboard.partitions-on-notice', compact('partitions'));
    }

    // Buildings Index
    public function buildingsIndex() {
        $buildings = Building::withCount(['floors', 'flats', 'partitions'])->orderBy('name')->get();

        return view('pages.dashboard.operations-parts.buildings.index', compact('buildings'));
    }

    // Buildinggs Show
    public function buildingsShow($slug) {
        $building = Building::withCount(['floors', 'flats', 'partitions'])->firstWhere('slug', $slug);

        return view('pages.dashboard.operations-parts.buildings.show', compact('building'));
    }

    // Floors Show
    public function floorsShow($id) {
        $floor = Floor::withCount(['flats', 'partitions'])->firstWhere('id', $id);
        $building = Building::firstWhere('id', $floor->building_id);

        return view('pages.dashboard.operations-parts.floors.show', compact('floor', 'building'));
    }

    // Flats Show
    public function flatsShow($id) {
        $flat = Flat::withCount('partitions')->firstWhere('id', $id);
        $partitions = Partition::where('flat_id', $flat->id)->get();

        return view('pages.dashboard.operations-parts.flats.show', compact('flat', 'partitions'));
    }

    // todaysInvoices
    public function todaysInvoices() {
        // Transactions
        $transactions = Transaction::with('building', 'floor', 'flat', 'partition', 'tenant', 'partition.building', 'partition.floor', 'partition.flat')->whereDate('created_at', '=', now())->latest()->get();
        $transactionsTotalAmountSum = $transactions->pluck('total_price')->sum();
        $transactionsBalanceSum = $transactions->pluck('balance')->sum();
        $transactionsCurrency = $transactions->pluck('currency')->first();

        // PayBalances
        $paybalances = PayBalance::with('invoice', 'building', 'floor', 'flat', 'partition', 'tenant', 'partition.building', 'partition.floor', 'partition.flat')->whereDate('created_at', '=', now())->latest()->get();
        $paybalancesInitialPaidAmountSum = $paybalances->pluck('initial_payment_amount')->sum();
        $paybalancesCurrentPaidAmountSum = $paybalances->pluck('current_payment_amount')->sum();
        $paybalancesTotalAmountSum = $paybalances->pluck('total_price')->sum();
        $paybalancesTotalPaymentAmountSum = $paybalancesTotalAmountSum - $paybalancesInitialPaidAmountSum;
        $paybalancesBalanceSum = $paybalances->pluck('balance')->sum();
        $paybalancesCurrency = $paybalances->pluck('currency')->first();

        // Card Receipts
        $cardReceipts = CardReceipt::with('card', 'tenant')->whereDate('created_at', '=', now())->where('from_transaction', 0)->latest()->get();
        $cardReceiptsPriceSum = $cardReceipts->pluck('card_price')->sum();

        return view('pages.dashboard.todays-transactions', compact('transactions', 'transactionsTotalAmountSum', 'transactionsBalanceSum', 'transactionsCurrency', 'paybalances', 'paybalancesCurrentPaidAmountSum', 'paybalancesTotalPaymentAmountSum', 'paybalancesBalanceSum', 'paybalancesCurrency', 'cardReceipts', 'cardReceiptsPriceSum'));
    }

    // toPayBalances
    public function toPayBalances() {
        $transactions = Transaction::where('balance', '>', 0)->where('paid_balance', 0)->latest()->get();

        return view('pages.dashboard.to-pay-balances', compact('transactions'));
    }
}
