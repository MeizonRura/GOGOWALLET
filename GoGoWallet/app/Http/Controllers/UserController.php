<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Endpoint 1: List user
    public function index()
    {
        return User::all();
    }

    // Endpoint 2: Detail user
    public function show($id)
    {
        return User::findOrFail($id);
    }

    // Endpoint 3: Tambah user
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    // Endpoint 4: Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    // Endpoint 5: Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}