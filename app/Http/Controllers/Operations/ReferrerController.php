<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Referrer;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReferrerController extends Controller
{
    // Show All Referrers
    public function index() {
        $referrers = Referrer::orderBy('name')->get();

        return view('operations.referrers.index', compact('referrers'));
    }

    // Add New Referrer
    public function create() {
        $countries = Country::orderBy('name')->get();

        return view('operations.referrers.create', compact('countries'));
    }

    // Store New Referrer
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
        ]);

        Referrer::create([
            'name' => $request->name,
            'idorpassport' => $request->idorpassport,
            'whatsapp_no' => $request->whatsapp_no,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'country_id' => $request->country_id,
        ]);

        return redirect()->route('referrers.index')->with('success', 'You have successfully created a referrer!');
    }

    // Show Single Referrer
    public function show($id) {
        $referrer = Referrer::findOrFail($id);
        $settings = Setting::firstWhere('id', 1);

        // Calculate Total Price From The Transactions Collection
        $transactions = Transaction::where('referrer_id', $referrer->id)->get();
        $totalPrice = $transactions->map(function ($transaction) {
            return $transaction->total_price;
        })->sum();

        return view('operations.referrers.show', compact('referrer', 'totalPrice', 'settings'));
    }

    // Edit Referrer
    public function edit($id) {
        $referrer = Referrer::firstWhere('id', $id);
        $countries = Country::orderBy('name')->get();

        return view('operations.referrers.edit', compact('referrer', 'countries'));
    }

    // Update Referrer
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
        ]);

        $referrer = Referrer::firstWhere('id', $id);
        $referrer->update([
            'name' => $request->name,
            'idorpassport' => $request->idorpassport,
            'whatsapp_no' => $request->whatsapp_no,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'country_id' => $request->country_id,
        ]);

        return redirect()->route('referrers.index')->with('success', 'You have successfully updated a referrer!');
    }

    // Destroy Referrer
    public function destroy($id) {
        $referrer = Referrer::firstWhere('id', $id);

        $referrer->delete();

        return redirect()->route('referrers.index')->with('success', 'You have successfully deleted a referrer!');
    }
}
