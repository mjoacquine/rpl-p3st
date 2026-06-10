<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportGenerator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // IMPORT FACADE PDF

class ReportController extends Controller
{
    protected $reportGenerator;

    public function __construct(ReportGenerator $reportGenerator)
    {
        $this->reportGenerator = $reportGenerator;
    }

    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $reportData = $this->reportGenerator->generateMonthlyReportData($month, $year);
        return view('Admin.Report.index', compact('reportData', 'month', 'year'));
    }

    public function exportPdf(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        // Ambil data
        $reportData = $this->reportGenerator->generateMonthlyReportData($month, $year);


        // dd($reportData); // Debug data sebelum diubah jadi PDF
        // Load view dan konversi ke PDF secara teknis
        $pdf = Pdf::loadView('Admin.Report.export_pdf', compact('reportData'))
                  ->setPaper('a4', 'portrait');

        // Mengembalikan file PDF asli, bukan HTML yang dipaksa jadi PDF
        return $pdf->download("Laporan_P3ST_{$year}_{$month}.pdf");
    }
}