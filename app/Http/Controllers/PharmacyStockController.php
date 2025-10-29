<?php

namespace App\Http\Controllers;

use App\Models\PharmacyStock;

class PharmacyStockController extends Controller
{
    public function getMedicine($code)
    {
        $medicine = PharmacyStock::where('code', $code)->first();

        if (!$medicine) {
            return response()->json(['error' => 'Medicine not found'], 404);
        }

        return response()->json([
            'name' => $medicine->name,
            'active_ingredient' => $medicine->active_ingredient,
            'rest_of_it' => $medicine->quantity,
            'unit_type' => $medicine->unit_type,
            'price' => $medicine->price,
        ]);
    }
}
