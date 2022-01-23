<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\CardReceipt;
use App\Models\Country;
use App\Models\FixedDeposit;
use App\Models\PayBalance;
use App\Models\Setting;
use App\Models\Tenant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class TenantController extends Controller
{
    // Show All Tenants
    public function index() {
        $tenants = Tenant::with('country')->orderBy('status', 'desc')->orderBy('name')->get();

        return view('operations.tenants.index', compact('tenants'));
    }

    // Create Tenant
    public function create() {
        $countries = Country::orderBy('name', 'asc')->get();

        return view('operations.tenants/create', compact('countries'));
    }

    // Store Tenant
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'idorpassport' => 'required|unique:tenants,idorpassport',
            // 'joined_date' => 'required',
            'whatsapp_no' => 'required|numeric',
            'gender' => 'required',
            // 'country_id' => 'required'
        ],
        [
            'name.required' => 'The full name field is required.',
            // 'joined_date.required' => 'The joined date field is required.',
            'idorpassport.required' => 'The passport no. field is required.',
            'idorpassport.unique' => 'The passport no. has already been taken.',
            'whatsapp_no' => 'The whatsapp no. field is required.',
            // 'country_id.required' => 'The country field is required.',
        ]);

        $tenant = Tenant::create([
            'name' => $request->name,
            'joined_date' => $request->joined_date ? date('Y-m-d', strtotime(str_replace(',', '', $request->joined_date))) : null,
            'idorpassport' => $request->idorpassport,
            'whatsapp_no' => $request->whatsapp_no,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'country_id' => $request->country_id,
            'fixed_deposit' => $request->fixed_deposit ? $request->fixed_deposit : 0,
            'previous_balance' => $request->previous_balance ? $request->previous_balance : 0,
        ]);

        // Update or create fixed deposit row
        FixedDeposit::updateOrCreate(
            [
                'tenant_id' => $tenant->id,
            ],
            [
                'deposit_amount' => $tenant->fixed_deposit,
            ]
        );

        return redirect()->route('tenants.index')->with('success', 'You have successfully created a new tenant!');
    }

    // Show Single Tenant
    public function show($id) {
        $tenant = Tenant::findOrFail($id);

        $settings = Setting::where('id', 1)->first();

        $transactions = Transaction::with('building', 'floor', 'flat', 'partition', 'partition.building', 'partition.floor', 'partition.flat')->where('tenant_id', $tenant->id)->get();

        $paybalances = PayBalance::with('invoice', 'building', 'floor', 'flat', 'partition', 'partition.building', 'partition.floor', 'partition.flat')->where('tenant_id', $tenant->id)->get();

        $cardreceipts = CardReceipt::with('card')->where('tenant_id', $tenant->id)->get();

        // Calculate Total Price From The Transactions Collection
        $totalPrice = $transactions->map(function ($transaction) {
            return $transaction->total_price;
        })->sum();

        return view('operations.tenants.show', compact('tenant', 'totalPrice', 'settings', 'transactions', 'paybalances', 'cardreceipts'));
    }

    // Edit Tenant
    public function edit($id) {
        $tenant = Tenant::findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();

        return view('operations.tenants.edit', compact('tenant', 'countries'));
    }

    // Update Tenant
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'idorpassport' => 'required',
            'whatsapp_no' => 'required|numeric',
            'gender' => 'required',
            // 'country_id' => 'required'
        ],
        [
            'name.required' => 'The full name field is required.',
            'idorpassport.required' => 'The passport no. field is required.',
            'idorpassport.unique' => 'The passport no. has already been taken.',
            'whatsapp_no' => 'The whatsapp no. field is required.',
            // 'country_id.required' => 'The country field is required.',
        ]);

        $tenant = Tenant::findOrFail($id);
        $tenant->update([
            'name' => $request->name,
            'idorpassport' => $request->idorpassport,
            'whatsapp_no' => $request->whatsapp_no,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'country_id' => $request->country_id,
            'status' => $request->status ? $request->status : $tenant->status,
            'fixed_deposit' => $request->fixed_deposit == null ? 0 : $request->fixed_deposit,
            'previous_balance' => $request->previous_balance == null ? 0 : $request->previous_balance,
        ]);

        // Update or create fixed deposit row
        FixedDeposit::updateOrCreate(
            [
                'tenant_id' => $tenant->id,
            ],
            [
                'deposit_amount' => $tenant->fixed_deposit,
            ]
        );

        return redirect()->back()->with('success', 'You have successfully updated a tenant!');
    }

    // Destroy Tenant
    public function destroy($id) {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'You have successfully deleted a tenant!');
    }
}
