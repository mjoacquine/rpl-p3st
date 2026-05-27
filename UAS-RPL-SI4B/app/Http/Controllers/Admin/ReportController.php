<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MonthlyReport; // Mengambil data olahan dari Service

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Mengambil ringkasan hitungan matematika ekonomi (SUM) dari Service
        $summary = MonthlyReport::getSummary($month, $year);
        
        // Mengambil list detail transaksi dari Service
        $reports = MonthlyReport::getDetail($month, $year);

        return view('admin.report.index', compact('reports', 'summary', 'month', 'year'));
    }
}