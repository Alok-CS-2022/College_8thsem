<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $clinicId = $request->user()->clinic_id;

        $patients = Patient::when($clinicId, fn ($q) => $q->where('clinic_id', $clinicId))
            ->latest()
            ->get();

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

        $validated['clinic_id'] = $request->user()->clinic_id;

        $patient = Patient::create($validated);

        return redirect()->route("appointments.create", ["patient" => $patient->id])
            ->with("success", "Patient registered. Now book an appointment.");
    }
}
