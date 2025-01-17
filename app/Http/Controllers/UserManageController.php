<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserManageController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');
        $users = User::when($role, function ($query, $role) {
            return $query->where('role', $role);
        })->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|required_if:role,participant',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image')->store('profile_pictures', 'public');
        }


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $profileImage,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|required_if:role,participant',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);


        $user = User::findOrFail($id);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $request->file('profile_image')->store('profile_pictures', 'public');
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $user->profile_image,
        ]);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function manageUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Implement user management logic (e.g., update, delete, block)
        return response()->json($user, 200);
    }
}
