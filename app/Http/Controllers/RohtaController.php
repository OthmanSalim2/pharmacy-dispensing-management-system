<?php

namespace App\Http\Controllers;

use App\Models\PharmacyStock;
use App\Models\RohtaMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RohtaController extends Controller
{
    // Show the prescription page
    public function index()
    {
        $pharmacyStock = PharmacyStock::all();
        $selectedMedicines = RohtaMedicine::where('user_id', Auth::id())->get();
        return view('albaraka.drugsell', compact('pharmacyStock', 'selectedMedicines'));
    }

    // Search medicines via AJAX
    public function search(Request $request)
    {
        $query = $request->get('query');
        $results = PharmacyStock::where('name', 'LIKE', "%{$query}%")
            ->orWhere('code', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    // Save prescription (Roshta)
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string',
            'roshta_medicines' => 'required|array',
            'roshta_medicines.*.medicine_code' => 'required|string|exists:pharmacy_stocks,code',
            'roshta_medicines.*.quantity' => 'required|integer|min:1',
            'roshta_medicines.*.unit_count' => 'required|integer|min:1',
            'roshta_medicines.*.unit_price' => 'required|numeric|min:0',
        ]);

        $user_id = auth()->id();
        $patient_name = $request->patient_name;

        foreach ($request->roshta_medicines as $med) {
            RohtaMedicine::create([
                'user_id' => $user_id,
                'patient_name' => $patient_name,
                'medicine_code' => $med['medicine_code'],
                'quantity' => $med['quantity'],
                'unit_price' => $med['unit_price'],
                'total' => $med['unit_price'] * $med['quantity'],

            ]);
        }

        return redirect()->back()->with('success', 'تم إضافة الروشتة بنجاح');
    }


    public function getMedicineByCode(Request $request)
    {
        $code = $request->get('code');
        $medicine = PharmacyStock::where('code', $code)->first();

        if ($medicine) {
            return response()->json($medicine);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }

    }

    public function storeRohta(Request $request)
    {
//        dd($request);
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'roshta_medicines' => 'required|string', // لاحظ أنها string لأنها JSON
        ]);

        $roshtaItems = json_decode($request->roshta_medicines, true);

        if (empty($roshtaItems)) {
            return back()->with('error', 'لم يتم إضافة أي علاج في الروشتة.');
        }

        DB::beginTransaction();
        try {
            foreach ($roshtaItems as $item) {
                // تحقق من كل حقل
                if (empty($item['medicine_code']) || empty($item['unit_count']) || empty($item['unit_price'])) {
                    DB::rollBack();
                    return back()->with('error', 'بيانات غير صالحة في أحد الأدوية.');
                }

                // إنشاء سجل لكل دواء
                RohtaMedicine::create([
                    'user_id' => Auth::id(),
                    'patient_name' => $request->patient_name,
                    'medicine_code' => $item['medicine_code'],
                    'quantity' => $item['unit_count'],
                    'unit_price' => $item['unit_price'],
                    'unit_type' => $item['unit_type'] ?? null,
                    'total' => $item['unit_price'] * $item['unit_count'],
                ]);

                // تحديث المخزون
                $stock = PharmacyStock::where('code', $item['medicine_code'])->first();
                if ($stock) {
                    if ($stock->quantity < $item['unit_count']) {
                        DB::rollBack();
                        return back()->with('error', "الكمية المتاحة من {$stock->name} غير كافية");
                    }
                    $stock->quantity -= $item['unit_count'];
                    $stock->save();
                }
            }

            DB::commit();
            return back()->with('success', 'تم صرف الروشتة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء الصرف: ' . $e->getMessage());
        }
    }

    public function pause(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string',
            'roshta_medicines' => 'required|array'
        ]);

        // حفظ الروشتة بحالة paused
        foreach ($request->roshta_medicines as $item) {
            RohtaMedicine::create([
                'user_id' => Auth::id(),
                'patient_name' => $request->patient_name,
                'medicine_code' => $item['medicine_code'],
                'quantity' => $item['unit_count'],
                'unit_type' => $item['unit_type'],
                'unit_price' => $item['unit_price'],
                'total' => $item['unit_price'] * $item['unit_count'],
                'status' => 'paused'
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function exempt(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string',
            'roshta_medicines' => 'required|array'
        ]);

        // حفظ الروشتة بحالة paused
        foreach ($request->roshta_medicines as $item) {
            RohtaMedicine::create([
                'user_id' => Auth::id(),
                'patient_name' => $request->patient_name,
                'medicine_code' => $item['medicine_code'],
                'quantity' => $item['unit_count'],
                'unit_type' => $item['unit_type'],
                'unit_price' => $item['unit_price'],
                'total' => $item['unit_price'] * $item['unit_count'],
                'status' => '',
                'is_exempt' => 1,
                'exemption_reason' => $request->exemption_reason,
            ]);
        }

        return response()->json(['success' => true]);
    }

}
