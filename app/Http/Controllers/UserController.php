<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:pending,active,suspended,blocked',
        ]);

        $user->update(['status' => $request->status]);

        return back()->with('success', "Updated {$user->name}'s status to {$request->status}.");
    }
}
