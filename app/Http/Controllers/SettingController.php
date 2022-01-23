<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // General Settings
    public function general() {
        $settings = Setting::orderBy('company_name', 'desc')->first();

        return view('settings.general', compact('settings'));
    }

    // Update General Settings
    public function updateGeneral(Request $request) {
        $request->validate([
            'company_name' => 'required',
            'company_phone_no' => 'required',
            'company_email' => 'required',
            'company_address' => 'required',
            'company_logo' => 'mimes:png,jpg,jpeg|max:1024'
        ]);

        $settings = Setting::findOrFail(1);

        if ($request->hasFile('company_logo')) {

            $destination_path = 'public/images/invoice_logos';
            $logo = $request->file('company_logo');
            $logo_name = strtolower(str_replace(' ', '-', $settings->company_name)) . '.' . $logo->getClientOriginalExtension();

            $logo->storeAs($destination_path, $logo_name);

        }

        $settings->update([
            'company_name' => $request->company_name,
            'company_phone_no' => $request->company_phone_no,
            'company_email' => $request->company_email,
            'company_address' => $request->company_address,
            'company_logo' => $request->company_logo ? $logo_name : $settings->company_logo,
        ]);

        return redirect()->route('settings.general')->with('success', 'You have successfully updated the general settings!');
    }

    // Invoice Settings
    public function invoice() {
        $settings = Setting::orderBy('company_name', 'desc')->first();

        return view('settings.invoice', compact('settings'));
    }

    // Update Invoice Settings
    public function updateInvoice(Request $request) {
        $request->validate([
            'invoice_prefix' => 'required',
            'invoice_theme_color' => 'required',
            'currency' => 'required',
            'card_price' => 'required',
        ]);

        $settings = Setting::findOrFail(1);
        $settings->update([
            'invoice_prefix' => $request->invoice_prefix,
            'invoice_theme_color' => $request->invoice_theme_color,
            'currency' => $request->currency,
            'card_price' => $request->card_price,
            'termsnconditions' => $request->termsnconditions ?? $request->termsnconditions,
        ]);

        return redirect()->route('settings.invoice')->with('success', 'You have successfully updated the invoice settings!');
    }
}
