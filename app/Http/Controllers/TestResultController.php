<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\MedicalCase;
use App\Models\TestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function index(Request $request)
    {
        $clinicId = $request->user()->clinic_id;
        $appointments = Appointment::with(["patient", "testResult"])
            ->when($clinicId, fn ($q) => $q->whereHas('patient', fn ($p) => $p->where('clinic_id', $clinicId)))
            ->latest()->get();
        return view("test_results.index", compact("appointments"));
    }

    public function create(Appointment $appointment) { return view("test_results.create", compact("appointment")); }

    public function store(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            "cbc" => "nullable|string", "hbsag" => "nullable|string", "vdrl" => "nullable|string",
            "hiv" => "nullable|string", "blood_group" => "nullable|string", "urine_test" => "nullable|string",
            "xray_findings" => "nullable|string", "flagged_abnormal" => "nullable|boolean",
            "report" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:10240",
        ]);
        $validated["patient_id"] = $appointment->patient_id;
        $validated["appointment_id"] = $appointment->id;
        $validated["status"] = "ready_for_review";
        $validated["flagged_abnormal"] = $request->has("flagged_abnormal");
        unset($validated['report']);

        if ($request->hasFile('report')) {
            $path = $request->file('report')->store('test-reports', 'public');
            $validated['report_path'] = $path;
            $validated['report_uploaded_at'] = now();
            $validated['report_uploaded_by'] = $request->user()->id;
        }

        TestResult::updateOrCreate(["appointment_id" => $appointment->id], $validated);
        $appointment->update(["status" => "completed"]);

        $medicalCase = $appointment->medicalCase;
        if ($medicalCase) {
            $medicalCase->update([
                'identity_verified' => true,
                'physical_exam_done' => true,
                'blood_test_done' => !empty($validated['blood_group']) || !empty($validated['cbc']),
                'xray_done' => !empty($validated['xray_findings']),
                'status' => 'doctor_review_pending',
            ]);
        }

        return redirect()->route("test-results.index")
            ->with("success", "Test results saved for " . $appointment->patient->full_name);
    }
}
