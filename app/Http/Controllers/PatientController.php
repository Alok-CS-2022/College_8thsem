<?php
namespace App\Http\Controllers;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $clinicId = $request->user()->clinic_id;
        $patients = Patient::when($clinicId, fn ($q) => $q->where('clinic_id', $clinicId))
            ->latest()->get();
        return view("patients.index", compact("patients"));
    }

    public function create() { return view("patients.create"); }

    public function store(Request $request)
    {
        $existing = Patient::where('passport_number', $request->input('passport_number'))->first();
        if ($existing) {
            throw ValidationException::withMessages([
                'passport_number' => "This passport number is already registered to {$existing->full_name}. Search for them instead of creating a duplicate.",
            ]);
        }

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

    public function show(Patient $patient)
    {
        $patient->load(['appointments.testResult', 'certificates']);

        $events = collect();
        $events->push(['label' => 'Patient registered', 'date' => $patient->created_at]);

        foreach ($patient->appointments as $appt) {
            $events->push(['label' => "Appointment booked ({$appt->queue_token})", 'date' => $appt->created_at]);
            if (in_array($appt->status, ['checked_in', 'in_progress', 'completed'])) {
                $events->push(['label' => "Checked in ({$appt->queue_token})", 'date' => $appt->updated_at]);
            }
            if ($appt->testResult) {
                $events->push(['label' => 'Test results recorded', 'date' => $appt->testResult->updated_at]);
            }
        }

        foreach ($patient->certificates as $cert) {
            $events->push(['label' => "Certificate issued ({$cert->status})", 'date' => $cert->created_at]);
        }

        $events = $events->sortBy('date')->values();

        return view('patients.show', compact('patient', 'events'));
    }
}
