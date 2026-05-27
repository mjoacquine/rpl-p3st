<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Menampilkan ringkasan metrik data aplikasi di beranda admin.
     */
    public function index()
    {
        // Menghitung jumlah total pengguna berdasarkan rolenya masing-masing
        $totalWarga = User::where('role', 'warga')->count();
        $totalPetugas = User::where('role', 'petugas')->count();

        // Menghitung sirkulasi dana tabungan dari semua transaksi yang sukses (Selesai)
        $totalSaldoPool = Transaction::where('status', 'selesai')->sum('price_final');

        // Mengambil 5 transaksi terbaru untuk dipantau langsung di dashboard
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact('totalWarga', 'totalPetugas', 'totalSaldoPool', 'recentTransactions'));
    }
}