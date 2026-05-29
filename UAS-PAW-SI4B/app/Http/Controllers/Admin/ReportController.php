<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportGenerator;
use Carbon\Carbon;

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
        
        $reportData = $this->reportGenerator->generateMonthlyReportData($month, $year);

        // Menggunakan standard native rendering View HTML ke format cetak ekspor PDF
        $html = view('Admin.Report.export_pdf', compact('reportData'))->render();
        
        // Logika konversi library (misal DomPDF) dijalankan di sini
        return response($html)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=Laporan_P3ST_{$year}_{$month}.pdf");
    }
}