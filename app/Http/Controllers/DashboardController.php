<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Certificate;
use App\Models\Patient;
use App\Models\TestResult;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $clinicId = $user->clinic_id;
        $clinic = $user->clinic;

        $patientQuery = Patient::when($clinicId, fn ($q) => $q->where('clinic_id', $clinicId));
        $appointmentQuery = Appointment::when($clinicId, fn ($q) => $q->whereHas('patient', fn ($p) => $p->where('clinic_id', $clinicId)));
        $testResultQuery = TestResult::when($clinicId, fn ($q) => $q->whereHas('patient', fn ($p) => $p->where('clinic_id', $clinicId)));
        $certificateQuery = Certificate::when($clinicId, fn ($q) => $q->whereHas('patient', fn ($p) => $p->where('clinic_id', $clinicId)));

        $stats = [
            'patients' => (clone $patientQuery)->count(),
            'appointments' => (clone $appointmentQuery)->count(),
            'testResults' => (clone $testResultQuery)->count(),
            'certificates' => (clone $certificateQuery)->count(),
        ];

        $pipeline = [
            'appointments_today' => (clone $appointmentQuery)->whereDate('appointment_date', today())->count(),
            'tests_pending' => (clone $appointmentQuery)->where('status', 'booked')->count(),
            'review_pending' => (clone $testResultQuery)->where('status', 'ready_for_review')->count(),
            'certificates_issued' => (clone $certificateQuery)->count(),
        ];

        $recentAppointments = (clone $appointmentQuery)->with('patient')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'pipeline', 'recentAppointments', 'clinic'));
    }
}
