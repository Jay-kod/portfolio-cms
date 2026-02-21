<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfGeneratorService
{
    public function generate(array $data, string $templateName): string
    {
        $pdf = Pdf::loadView("resumes.{$templateName}", $data);
        
        // Setup options for better rendering
        $pdf->setPaper('a4', 'portrait');
        $pdf->setWarnings(false);
        
        $fileName = 'resumes/' . Str::random(40) . '.pdf';
        
        Storage::put('public/' . $fileName, $pdf->output());

        return $fileName;
    }
}
