<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show create/update form
    public function create()
    {
        return view('albaraka.newUser');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'workplace' => 'required|string|in:store,pharmacy',
            'role' => 'required|string|in:admin,user',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->workplace = $request->workplace;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('add-user')->with('success', 'تم إضافة المستخدم بنجاح!');
    }


    public function editWorkplace()
    {
        $allUsers = User::all();
        return view('albaraka.modifyWorkplace', compact('allUsers'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $users = User::where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'workplace')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    public function updateWorkplace(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'workplace' => ['required', 'string'],
            'role' => ['required', 'string'],
        ]);

        $user = User::findOrFail($request->user_id);
        $user->workplace = $request->workplace;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('edit-workplace')->with('success', 'تم تعديل مكان العمل بنجاح!');
    }

    public function index()
    {
        $users = User::all(); // You can also paginate if needed
        return view('albaraka.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('albaraka.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|max:50'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }


}
