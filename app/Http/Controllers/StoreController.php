<?php

namespace App\Http\Controllers;

use App\Models\PharmacyStock;
use App\Models\Sale;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        return view('albaraka.lookAtStuk');
    }

    public function mainStock()
    {
        $stores = Store::paginate(15);
        return view('albaraka.stockCopy', compact('stores'));
    }

    public function pharmacyStock()
    {
        $pharmacy_stocks = PharmacyStock::paginate(15);
        return view('albaraka.stokFarmaCopy', compact('pharmacy_stocks'));
    }

    public function showBuyMedicine()
    {
        return view('albaraka.buyMedicine');
    }

    public function showSaleMedicine()
    {
        return view('albaraka.saleMedicine');
    }

    public function storeMedicine(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'active_ingredient' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'string', 'max:255'],
            'type_of_medication' => ['required', 'string', 'max:255'],
            'unit_type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric:', 'min:0'],
            'pharmacy_price' => ['required', 'numeric:', 'min:0'],
            'patient_price' => ['required', 'numeric:', 'min:0'],
            'date' => ['required', 'date'],
            'expiration_date' => ['nullable', 'date'],
            'shipping_price' => ['nullable', 'numeric:', 'min:0'],
            'note' => ['nullable', 'string', 'max:255'],
            'pills_per_strip' => ['required', 'string', 'max:255'],
            'strips_per_box' => ['required', 'string', 'max:255'],
        ]);

        // Create the medicine
        $medicine = Store::create([
            'code' => $request->code,
            'name' => $request->name,
            'active_ingredient' => $request->active_ingredient,
            'quantity' => $request->quantity,
            'type_of_medication' => $request->type_of_medication,
            'unit_type' => $request->unit_type,
            'price' => $request->price,
            'pharmacy_price' => $request->pharmacy_price,
            'patient_price' => $request->patient_price,
            'date' => $request->date,
            'expiration_date' => $request->expiration_date,
            'shipping_price' => $request->shipping_price,
            'note' => $request->note,
            'pills_per_strip' => $request->pills_per_strip,
            'strips_per_box' => $request->strips_per_box,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'تم شراء الدواء بنجاح!');
    }

    public function getMedicineInfo($code)
    {
        $medicine = Store::where('code', $code)->first();

        if ($medicine) {
            return response()->json([
                'name' => $medicine->name,
                'active_ingredient' => $medicine->active_ingredient,
                'type_of_medication' => $medicine->type_of_medication,
                'unit_type' => $medicine->unit_type,
                'price' => $medicine->price,
                'pharmacy_price' => $medicine->pharmacy_price,
                'patient_price' => $medicine->patient_price,
                'quantity' => $medicine->quantity,
                'strips_per_box' => $medicine->strips_per_box,
                'pills_per_strip' => $medicine->pills_per_strip,
            ]);
        }

        return response()->json(['error' => 'هذا الدواء غير موجود'], 404);
    }

    public function saleMedicine(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_type' => ['required', 'string', 'in:علبة,شريط,حبة'],
            'price' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'shipping_price' => ['nullable', 'numeric', 'min:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $store = Store::where('code', $validated['code'])->first();

        if (!$store) {
            return back()->withErrors(['code' => 'هذا الدواء غير موجود في المخزن']);
        }

        $pills_per_box = $store->strips_per_box * $store->pills_per_strip;
        $total_pills_in_stock = $store->quantity * $pills_per_box;

        switch ($validated['unit_type']) {
            case 'علبة':
                $pills_to_sell = $validated['quantity'] * $pills_per_box;
                break;
            case 'شريط':
                $pills_to_sell = $validated['quantity'] * $store->pills_per_strip;
                break;
            case 'حبة':
            default:
                $pills_to_sell = $validated['quantity'];
                break;
        }

        if ($pills_to_sell > $total_pills_in_stock) {
            return back()->withErrors(['quantity' => 'الكمية المطلوبة أكبر من المخزون المتوفر']);
        }

        $remaining_pills = $total_pills_in_stock - $pills_to_sell;
        $store->quantity = intdiv($remaining_pills, $pills_per_box);
        $store->save();

        // ✅ Record the sale
        Sale::create([
            'code' => $store->code,
            'name' => $store->name,
            'quantity' => $validated['quantity'],
            'unit_type' => $validated['unit_type'],
            'price' => $validated['price'],
            'total' => $validated['quantity'] * $validated['price'],
            'date' => $validated['date'],
            'shipping_price' => $validated['shipping_price'],
            'note' => $validated['note'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('show-sales')->with('success', 'تم بيع الدواء وتسجيل العملية بنجاح');

    }

    public function showSales()
    {
        $sales = Sale::latest()->get();
        return view('albaraka.sales.reports', compact('sales'));
    }
}
