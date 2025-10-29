<?php

namespace App\Http\Controllers;

use App\Models\PharmacyStock;
use Illuminate\Http\Request;

class MedicineStoreController extends Controller
{
    public function create()
    {
        return view('albaraka.adding');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:pharmacy_stocks,code'],
            'quantity' => ['required', 'integer', 'min:0'],
            'active_ingredient' => ['nullable', 'string', 'max:255'],
            'unit_type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'pharmacy_price' => ['required', 'numeric', 'min:0'],
            'patient_price' => ['required', 'numeric', 'min:0'],
//            'date' => ['required', 'date'],
            'expiration_date' => ['required', 'date'],
            'treatment_type' => ['required', 'string', 'max:255'],
            'shipping_price' => ['required', 'numeric', 'min:0'],
        ]);


        // Create new stock entry
        $stock = PharmacyStock::create($validated);

        // Return success response (JSON for AJAX or redirect for form)
//        flash()->success('تم إضافة الدواء بنجاح');
        return redirect()->back()->with('success', 'تم إضافة الدواء بنجاح');
    }
}
