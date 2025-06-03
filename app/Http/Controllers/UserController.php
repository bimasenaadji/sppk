<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('master-user.index');
    }

    public function data()
    {
        $data = User::select(['id', 'name', 'email', 'position', 'phone']);
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'position' => $request->position,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $data = $request->only(['name', 'email', 'position', 'phone']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }
}
