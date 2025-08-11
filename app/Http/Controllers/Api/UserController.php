<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //

    // GET /users
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // POST /users
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|unique:users,email',
            'password'   => 'required|string|min:6',
            'username'   => 'nullable|string|unique:users,username',
            'user_type'  => 'required|string',
            'mobile_no'  => 'nullable|numeric',
            'shop_name'  => 'nullable|string',
            'profile_image' => 'nullable|string',
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'username'   => $request->username,
            'user_type'  => $request->user_type,
            'mobile_no'  => $request->mobile_no,
            'shop_name'  => $request->shop_name,
            'profile_image' => $request->profile_image,
        ]);

        return response()->json($user, 201);
    }

    // GET /users/{id}
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user, 200);
    }

    // PUT /users/{id}
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'name'       => 'sometimes|required|string|max:255',
            'email'      => 'nullable|email|unique:users,email,' . $id,
            'password'   => 'nullable|string|min:6',
            'username'   => 'nullable|string|unique:users,username,' . $id,
            'user_type'  => 'sometimes|required|string',
            'mobile_no'  => 'nullable|numeric',
            'shop_name'  => 'nullable|string',
            'profile_image' => 'nullable|string',
        ]);

        $user->update([
            'name'       => $request->name ?? $user->name,
            'email'      => $request->email ?? $user->email,
            'password'   => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'username'   => $request->username ?? $user->username,
            'user_type'  => $request->user_type ?? $user->user_type,
            'mobile_no'  => $request->mobile_no ?? $user->mobile_no,
            'shop_name'  => $request->shop_name ?? $user->shop_name,
            'profile_image' => $request->profile_image ?? $user->profile_image,
        ]);

        return response()->json($user, 200);
    }

    // DELETE /users/{id}
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
