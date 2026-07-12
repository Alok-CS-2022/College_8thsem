<?php
namespace App\Http\Controllers;
use App\Jobs\GenerateCertificatePdf;
use App\Models\Certificate;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $clinicId = $request->user()->clinic_id;

        $pendingReview = TestResult::with("patient")
            ->where("status", "ready_for_review")
            ->when($clinicId, fn ($q) => $q->whereHas('patient', fn ($p) => $p->where('clinic_id', $clinicId)))
            ->get();

        $certificates = Certificate::with("patient")
            ->when($clinicId, fn ($q) => $q->whereHas('patient', fn ($p) => $p->where('clinic_id', $clinicId)))
            ->latest()->get();

        return view("certificates.index", compact("pendingReview", "certificates"));
    }

    public function store(Request $request, TestResult $testResult)
    {
        $validated = $request->validate(["status" => "required|in:fit,unfit,requires_review"]);

        $medicalCase = $testResult->appointment?->medicalCase;

        if ($medicalCase && !$medicalCase->isReadyForCertificate()) {
            throw ValidationException::withMessages([
                'status' => 'Certificate cannot be generated: required examination steps are incomplete.',
            ]);
        }

        $certificate = Certificate::create([
            "patient_id" => $testResult->patient_id,
            "test_result_id" => $testResult->id,
            "doctor_id" => auth()->id(),
            "status" => $validated["status"],
            "issue_date" => now(),
            "expiry_date" => now()->addMonths(6),
        ]);

        $testResult->update(["status" => "reviewed"]);

        if ($medicalCase) {
            $medicalCase->update([
                'doctor_reviewed' => true,
                'status' => $validated['status'] === 'unfit' ? 'rejected' : 'certificate_generated',
                'assigned_doctor_id' => auth()->id(),
            ]);
        }

        GenerateCertificatePdf::dispatch($certificate);

        return redirect()->route("certificates.index")
            ->with("success", "Certificate generated for " . $testResult->patient->full_name . ". PDF is being generated.");
    }
}
