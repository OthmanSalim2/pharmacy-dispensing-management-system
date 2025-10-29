<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\PharmacyStock;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = PharmacyStock::all();
        return view('albaraka.stokFarma', compact('medicines'));
    }

    public function showPharmacyOrders()
    {
        return view('albaraka.mackRequest');
    }

    public function getMedicine($code)
    {
        $medicine = Pharmacy::where('code', $code)->first();

        if ($medicine) {
            return response()->json([
                'success' => true,
                'medicine' => [
                    'name' => $medicine->name,
                    'active_ingredient' => $medicine->active_ingredient,
                    'quantity' => $medicine->quantity,
                ]
            ]);
        }

        return response()->json(['success' => false]);
    }


    public function showOrders()
    {
        return view('albaraka.requests');
    }

    public function showPharmacyOrderArchive()
    {
        $orders = Order::paginate();
        return view('albaraka.pharmacy_order_archive', compact('orders'));
    }

    public function archive(Request $request)
    {
        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('active_ingredient', 'like', "%{$search}%");
        }

        $orders = $query->paginate(10);
        return view('albaraka.pharmacy_order_archive', compact('orders'));
    }


}
