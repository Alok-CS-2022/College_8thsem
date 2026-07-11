<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $clinicId = $request->user()->clinic_id;

        $appointments = Appointment::with("patient")
            ->when($clinicId, fn ($q) => $q->whereHas('patient', fn ($p) => $p->where('clinic_id', $clinicId)))
            ->latest()
            ->get();

        return view("appointments.index", compact("appointments"));
    }

    public function create(Request $request)
    {
        $clinicId = $request->user()->clinic_id;

        $patients = Patient::when($clinicId, fn ($q) => $q->where('clinic_id', $clinicId))->get();

        $selectedPatientId = $request->query("patient");

        return view("appointments.create", compact("patients", "selectedPatientId"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "patient_id" => "required|exists:patients,id",
            "appointment_date" => "required|date",
            "appointment_time" => "required",
        ]);

        $validated["queue_token"] = "T" . str_pad((string) (Appointment::count() + 1), 4, "0", STR_PAD_LEFT);
        $validated["status"] = "booked";

        Appointment::create($validated);

        return redirect()->route("appointments.index")
            ->with("success", "Appointment booked successfully.");
    }
}
