<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(["patient", "testResult"])->latest()->get();
        return view("test_results.index", compact("appointments"));
    }

    public function create(Appointment $appointment)
    {
        return view("test_results.create", compact("appointment"));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            "cbc" => "nullable|string",
            "hbsag" => "nullable|string",
            "vdrl" => "nullable|string",
            "hiv" => "nullable|string",
            "blood_group" => "nullable|string",
            "urine_test" => "nullable|string",
            "xray_findings" => "nullable|string",
            "flagged_abnormal" => "nullable|boolean",
        ]);

        $validated["patient_id"] = $appointment->patient_id;
        $validated["appointment_id"] = $appointment->id;
        $validated["status"] = "ready_for_review";
        $validated["flagged_abnormal"] = $request->has("flagged_abnormal");

        TestResult::updateOrCreate(
            ["appointment_id" => $appointment->id],
            $validated
        );

        $appointment->update(["status" => "completed"]);

        return redirect()->route("test-results.index")
            ->with("success", "Test results saved for " . $appointment->patient->full_name);
    }
}
