<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();
        return view("patients.index", compact("patients"));
    }

    public function create()
    {
        return view("patients.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "passport_number" => "required|string|unique:patients,passport_number",
            "full_name" => "required|string",
            "date_of_birth" => "required|date",
            "gender" => "required|string",
            "address" => "required|string",
            "phone" => "required|string",
            "destination_country" => "required|string",
            "manpower_agency" => "nullable|string",
        ]);

        $patient = Patient::create($validated);

        return redirect()->route("appointments.create", ["patient" => $patient->id])
            ->with("success", "Patient registered. Now book an appointment.");
    }
}
