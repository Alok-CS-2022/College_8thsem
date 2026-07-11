<?php

namespace App\Jobs;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateCertificatePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Certificate $certificate)
    {
    }

    public function handle(): void
    {
        $this->certificate->load('patient', 'doctor', 'testResult');

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $this->certificate,
        ]);

        $filename = 'certificates/certificate-' . $this->certificate->id . '.pdf';

        Storage::disk('public')->put($filename, $pdf->output());

        $this->certificate->update(['pdf_path' => $filename]);
    }
}
