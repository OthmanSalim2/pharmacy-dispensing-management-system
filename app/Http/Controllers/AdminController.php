<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('albaraka.adminSitting', ['users' => $users]);
    }

    public function update(Request $request)
    {
        // Get the selected user ID from the form
        $userId = $request->input('user_id');

        // Find the user by ID
        $user = User::findOrFail($userId);

        // Validate input
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'new_password' => 'nullable|string|min:6|confirmed', // requires new_password_confirmation
        ]);

        // Update username
        $user->username = $request->username;

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Save changes
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }


}
