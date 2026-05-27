<?php
namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\CatalogPrice;
use App\Services\NotificationService; // 1. IMPORT SERVICE API

class TransactionController extends Controller
{
    // Fungsi Edit yang sebelumnya terlewat
    public function edit($id)
    {
        $transaction = Transaction::with(['user', 'catalogPrice'])->where('transaction_id', $id)->firstOrFail();
        
        // Proteksi agar petugas tidak menimbang ulang transaksi yang sudah selesai/batal
        if ($transaction->status !== 'menunggu') {
            return redirect('/petugas/tugas')->withErrors(['error' => 'Transaksi ini sudah diproses sebelumnya.']);
        }

        return view('petugas.transaction.edit', compact('transaction'));
    }

    // 2. MASUKKAN SERVICE API SEBAGAI PARAMETER (Dependency Injection)
    public function update(Request $request, $id, NotificationService $notifService)
    {
        $request->validate([
            'weight_actual' => 'required|numeric|min:0.1', 
            'status' => 'required|in:selesai,batal'
        ]);

        $transaction = Transaction::where('transaction_id', $id)->firstOrFail();
        $priceFinal = 0.00;

        if ($request->status === 'selesai') {
            $catalog = CatalogPrice::where('category_id', $transaction->category_id)->first();
            $hargaPerKg = $catalog ? $catalog->price : 0;
            $priceFinal = $request->weight_actual * $hargaPerKg;
        }

        $transaction->update([
            'weight_actual' => $request->weight_actual,
            'price_final' => $priceFinal,
            'status' => $request->status
        ]);

        // 3. JALANKAN API NOTIFIKASI DI SINI JIKA SELESAI
        if ($request->status === 'selesai') {
            $pesan = "Halo {$transaction->user->name}, Sampah sudah dijemput! Saldo bertambah Rp " . number_format($priceFinal, 0, ',', '.');
            $notifService->sendNotification($transaction->user_id, $pesan, $transaction->user->phone);
        }

        return redirect('/petugas/tugas')->with('success', 'Tugas penjemputan ' . $id . ' berhasil diselesaikan!');
    }
}