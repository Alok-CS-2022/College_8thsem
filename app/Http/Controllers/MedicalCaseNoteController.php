<?php
namespace App\Http\Controllers;
use App\Models\MedicalCase;
use Illuminate\Http\Request;

class MedicalCaseNoteController extends Controller
{
    public function store(Request $request, MedicalCase $medicalCase)
    {
        $validated = $request->validate([
            'type' => 'required|in:medical,administrative,review',
            'content' => 'required|string',
        ]);

        $medicalCase->notes()->create([
            'user_id' => $request->user()->id,
            'type' => $validated['type'],
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Note added.');
    }
}
