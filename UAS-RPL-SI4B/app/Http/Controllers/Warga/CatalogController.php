<?php
namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\CatalogPrice;

class CatalogController extends Controller
{
    public function index()
    {
        // Mengambil semua daftar harga sampah dari database
        $catalogs = CatalogPrice::all();
        
        return view('warga.catalog.index', compact('catalogs'));
    }
}