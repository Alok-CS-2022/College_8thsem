<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

        $patient = Patient::findOrFail($validated['patient_id']);

        $clash = Appointment::where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['booked', 'checked_in', 'in_progress'])
            ->whereHas('patient', fn ($p) => $p->where('clinic_id', $patient->clinic_id))
            ->exists();

        if ($clash) {
            throw ValidationException::withMessages([
                'appointment_time' => 'This time slot is already booked at this clinic. Please choose another time.',
            ]);
        }

        $validated["queue_token"] = "T" . str_pad((string) (Appointment::count() + 1), 4, "0", STR_PAD_LEFT);
        $validated["status"] = "booked";

        Appointment::create($validated);

        return redirect()->route("appointments.index")
            ->with("success", "Appointment booked successfully.");
    }

    public function checkIn(Appointment $appointment)
    {
        $appointment->update(['status' => 'checked_in']);

        return back()->with('success', "Checked in {$appointment->patient->full_name}.");
    }
}
