<?php
namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class RouteController extends Controller
{
    public function show($id)
    {
        // Menampilkan detail spesifik satu transaksi penjemputan
        $task = Transaction::with('user')->where('transaction_id', $id)->firstOrFail();

        return view('petugas.route.show', compact('task'));
    }
}