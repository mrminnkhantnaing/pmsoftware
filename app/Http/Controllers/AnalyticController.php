<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Setting;
use App\Models\CardReceipt;
use App\Models\Tenant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticController extends Controller
{
    // Transactions Analytics
    public function index() {
        // Settings
        $settings = Setting::firstWhere('id', 1);

        // Transaction Count Statistics
        $currentMonthTransactionsCount = Transaction::whereDate('created_at', '>', Carbon::now()->subDays(30)->toDateTimeString())->count();
        $lastMonthTransactionsCount = Transaction::whereDate('created_at', '>', Carbon::now()->subDays(60)->toDateTimeString())->whereDate('created_at', '<', Carbon::now()->subDays(31)->toDateTimeString())->count();

        // Revenue Transaction Statistics
        $currentMonthTransactions = Transaction::whereDate('created_at', '>', Carbon::now()->subDays(30)->toDateTimeString())->get();
        $currentMonthRevenue = 0;
        foreach ($currentMonthTransactions as $transaction) {
            $currentMonthRevenue += $transaction->sub_total;
        }

        $lastMonthTransactions = Transaction::whereDate('created_at', '>', Carbon::now()->subDays(60)->toDateTimeString())->whereDate('created_at', '<', Carbon::now()->subDays(31)->toDateTimeString())->get();
        $lastMonthRevenue = 0;
        foreach ($lastMonthTransactions as $transaction) {
            $lastMonthRevenue += $transaction->sub_total;
        }

        // Revenue Card Receipt Statistics
        $currentMonthCardReceipts = CardReceipt::where('created_at', '>', Carbon::now()->subDays(30)->toDateTimeString())->where('returned_date', null)->get();

        $currentMonthCardRevenue = 0;
        foreach ($currentMonthCardReceipts as $card_receipt) {
            $currentMonthCardRevenue += $card_receipt->card_price;
        }

        $lastMonthCardReceipts = CardReceipt::whereDate('created_at', '>', Carbon::now()->subDays(60)->toDateTimeString())->whereDate('created_at', '<', Carbon::now()->subDays(31)->toDateTimeString())->where('returned_date', null)->get();

        $lastMonthCardRevenue = 0;
        foreach ($lastMonthCardReceipts as $card_receipt) {
            $lastMonthCardRevenue += $card_receipt->card_price;
        }

        // Analytics for Line Chart
        // $transactionsAmount = Transaction::select(
        //     DB::raw("monthname(created_at) as monthname"),
        //     DB::raw("SUM(total_price) as total_price"))
        //     ->orderBy('created_at')
        //     ->where('created_at', '>=', Carbon::now()->subMonths(12)->toDateTimeString())
        //     ->groupBy(DB::raw("monthname(created_at)"))
        //     ->get()->toJson();

        $transactionsAmount = Transaction::select(
            DB::raw("SUM(total_price) as total_price"),
            DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
            DB::raw('YEAR(created_at) year, MONTHNAME(created_at) monthname'))
            ->groupby('year','monthname')
            ->where('created_at', '>=', Carbon::now()->subMonths(12)->toDateTimeString())
            ->orderBy('created_at')
            ->get();

        return view('pages.analytics.invoices', compact('settings', 'currentMonthTransactionsCount', 'lastMonthTransactionsCount', 'currentMonthRevenue', 'lastMonthRevenue', 'currentMonthCardRevenue', 'lastMonthCardRevenue', 'transactionsAmount'));
    }

    // Tenants Analytics
    public function tenants() {
        // Settings
        $settings = Setting::where('id', 1)->first();

        // Total Tenants
        $totalTenantsCount = Tenant::count();

        // Tenant Count Statistics
        $currentMonthTenantsCount = Tenant::whereDate('created_at', '>', Carbon::now()->subDays(30)->toDateTimeString())->count();
        $lastMonthTenantsCount = Tenant::whereDate('created_at', '>', Carbon::now()->subDays(60)->toDateTimeString())->whereDate('created_at', '<', Carbon::now()->subDays(31)->toDateTimeString())->count();

        // Active Tenants
        $activeTenantsCount = Tenant::where('status', 1)->count();

        $currentMonthActiveTenantsCount = Tenant::where('status', 1)->whereDate('created_at', '>', Carbon::now()->subDays(30)->toDateTimeString())->count();
        $lastMonthActiveTenantsCount = Tenant::where('status', 1)->whereDate('created_at', '>', Carbon::now()->subDays(60)->toDateTimeString())->whereDate('created_at', '<', Carbon::now()->subDays(31)->toDateTimeString())->count();

        // New Tenants Line Chart
        $newTenantsChart = Tenant::select(
            DB::raw("COUNT(*) as new_tenants_count"),
            DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
            DB::raw('YEAR(created_at) year, MONTHNAME(created_at) monthname'))
            ->groupby('year','monthname')
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->toDateTimeString())
            ->orderBy('created_at')
            ->get();

        // Tenants' Gender
        $tenantsMaleCount = Tenant::select('gender')->where('gender', 'male')->count();
        $tenantsFemaleCount = Tenant::select('gender')->where('gender', 'female')->count();

        // Tenants' Countries

        // $tenantsCountries = Tenant::select(
        //     DB::raw("SUM(country_id) as country_id_count"),
        //     DB::raw('YEAR(created_at) year, MONTHNAME(created_at) monthname'))
        //     ->groupby('year','monthname')
        //     ->where('created_at', '>=', Carbon::now()->subMonths(6)->toDateTimeString())
        //     ->orderBy('created_at')
        //     ->get();
        // $tenantsCountriesChart = Tenant::select('country_id')->groupby('country_id')->get();

        // $tenantsCountriesChart = Tenant::with(['country' => function($query) {
        //     $query->select('id', 'name')->count();
        // }])->groupby('country_id')->get();

        // $tenantsCountriesChart = DB::table('tenants')
        // ->select('tenants.*',DB::raw('COUNT(country_id) as count'))
        // ->groupBy('country_id')
        // ->orderBy('country_id')
        // ->get();

        $tenantsCountriesChart = DB::table('tenants')
            ->join('countries', 'countries.id', '=', 'tenants.country_id')
            ->select(
                'countries.name AS name',
                DB::raw("count(countries.name) AS total_country"))
            ->groupBy('tenants.country_id')
            ->orderBy('total_country', 'desc')
            ->limit(16)
            ->get();

        // Tenants Country Count (Total)
        $tenantsCountriesCount = Tenant::select('country_id')->groupby('country_id')->get();

        $totalCountryCount = 0;
        foreach($tenantsCountriesCount as $tenant) {
            $totalCountryCount += 1;
        }

        return view('pages.analytics.tenants', compact('settings', 'totalTenantsCount', 'currentMonthTenantsCount', 'lastMonthTenantsCount', 'activeTenantsCount', 'currentMonthActiveTenantsCount', 'lastMonthActiveTenantsCount', 'newTenantsChart', 'tenantsMaleCount', 'tenantsFemaleCount', 'tenantsCountriesChart', 'totalCountryCount'));
    }

    // New Tenants
    public function newTenants() {
        $newTenants = Tenant::whereDate('created_at', '>=', Carbon::now()->subDays(30)->toDateString())->orderBy('created_at', 'desc')->get();

        return view('pages.analytics.new-tenants', compact('newTenants'));
    }

    // Active Tenants
    public function activeTenants() {
        $activeTenants = Tenant::where('status', 1)->orderBy('created_at', 'desc')->get();

        return view('pages.analytics.active-tenants', compact('activeTenants'));
    }
}
