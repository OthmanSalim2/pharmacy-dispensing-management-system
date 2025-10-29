<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PharmacyStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmacyOrderController extends Controller
{
    public function index(Request $request)
    {
        $queryDate = $request->input('date');

        $pendingOrders = Order::where('status', 'pending')
            ->when($queryDate, fn($q) => $q->whereDate('created_at', $queryDate))
            ->get();

        $completedOrders = Order::where('status', 'completed')
            ->when($queryDate, fn($q) => $q->whereDate('updated_at', $queryDate))
            ->get();

        $cancelledOrders = Order::where('status', 'cancelled')
            ->when($queryDate, fn($q) => $q->whereDate('updated_at', $queryDate))
            ->get();

        return view('albaraka.requests', compact('pendingOrders', 'completedOrders', 'cancelledOrders'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|array|min:1',
            'code.*' => 'required|string|max:255',
            'name' => 'nullable|array',
            'name.*' => 'nullable|string|max:255',
            'active_ingredient' => 'nullable|array',
            'active_ingredient.*' => 'nullable|string|max:255',
            'rest_of_it' => 'nullable|array',
            'rest_of_it.*' => 'nullable|string|max:255',
            'required_quantity' => 'required|array',
            'required_quantity.*' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        foreach ($request->code as $index => $code) {
            $pharmacy_stock = PharmacyStock::where('code', $code)->first();

            Order::create([
                'code' => $code,
                'name' => $request->name[$index] ?? null,
                'active_ingredient' => $request->active_ingredient[$index] ?? null,
                'rest_of_it' => $request->rest_of_it[$index] ?? null,
                'required_quantity' => $request->required_quantity[$index],
                'status' => 'pending',
                'note' => $request->note,
                'price' => $pharmacy_stock->price ?? 0,
                'unit_type' => $pharmacy_stock->unit_type ?? null,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->back()->with('success', 'تم إرسال جميع الطلبات بنجاح ✅');
    }

    public function accept($id)
    {
        $order = Order::findOrFail($id);
        $pharmacyStock = PharmacyStock::where('code', $order->code)->first();

        if ($pharmacyStock) {
            // Decrease stock quantity safely
            $pharmacyStock->quantity = max(0, $pharmacyStock->quantity - $order->required_quantity);
            $pharmacyStock->save();

            // ✅ Update order.rest_of_it with latest stock quantity
            $order->rest_of_it = $pharmacyStock->quantity;
        } else {
            // If stock record not found, set rest_of_it = 0
            $order->rest_of_it = 0;
        }

        // Update order status
        $order->status = 'completed';
        $order->save();

        return redirect()->back()->with('success', 'تم قبول الطلب بنجاح ✅');
    }


    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'تم إلغاء الطلب بنجاح ❌');
    }


}
