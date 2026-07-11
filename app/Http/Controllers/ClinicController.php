<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {
        $clinics = Clinic::latest()->get();

        return view('clinics.index', compact('clinics'));
    }

    public function updateStatus(Request $request, Clinic $clinic)
    {
        $request->validate([
            'status' => 'required|in:submitted,under_review,approved,active,suspended,revoked',
        ]);

        $clinic->update(['status' => $request->status]);

        return back()->with('success', "Updated {$clinic->name}'s status to {$request->status}.");
    }
}
