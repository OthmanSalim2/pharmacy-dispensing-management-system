<?php

namespace App\Http\Controllers;

use App\Models\RohtaMedicine;

class ShowRoshtaController extends Controller
{
    public function showPrescriptionArchive()
    {
        $roshitas = RohtaMedicine::with('medicine')->orderBy('created_at', 'desc')->paginate(10);

        return view('albaraka.roshitaArshief', compact('roshitas'));
    }

    public function updateStatus($id)
    {
        $roshta = RohtaMedicine::findOrFail($id);

        // Toggle status logic
        if ($roshta->status === 'paused') {
            $roshta->status = '';
        } else {
            $roshta->status = 'paused';
        }

        $roshta->save();

        return redirect()->back()->with('success', 'تم تحديث حالة الروشتة بنجاح');
    }
}
