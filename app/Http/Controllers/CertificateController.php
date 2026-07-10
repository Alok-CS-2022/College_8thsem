<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\TestResult;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $pendingReview = TestResult::with("patient")
            ->where("status", "ready_for_review")
            ->get();

        $certificates = Certificate::with("patient")->latest()->get();

        return view("certificates.index", compact("pendingReview", "certificates"));
    }

    public function store(Request $request, TestResult $testResult)
    {
        $validated = $request->validate([
            "status" => "required|in:fit,unfit,requires_review",
        ]);

        $certificate = Certificate::create([
            "patient_id" => $testResult->patient_id,
            "test_result_id" => $testResult->id,
            "doctor_id" => auth()->id(),
            "status" => $validated["status"],
            "issue_date" => now(),
            "expiry_date" => now()->addMonths(6),
        ]);

        $testResult->update(["status" => "reviewed"]);

        return redirect()->route("certificates.index")
            ->with("success", "Certificate generated for " . $testResult->patient->full_name);
    }
}
