<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatalogPrice;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = CatalogPrice::all();
        return view('admin.catalog.index', compact('catalogs'));
    }

    public function create()
    {
        return view('admin.catalog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:10'
        ]);

        CatalogPrice::create([
            'category_name' => $request->category_name,
            'price' => $request->price,
            'unit' => $request->unit
        ]);

        return redirect('/admin/katalog')->with('success', 'Kategori sampah baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $catalog = CatalogPrice::findOrFail($id);
        return view('admin.catalog.edit', compact('catalog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:10'
        ]);

        $catalog = CatalogPrice::findOrFail($id);
        $catalog->update([
            'category_name' => $request->category_name,
            'price' => $request->price,
            'unit' => $request->unit
        ]);

        return redirect('/admin/katalog')->with('success', 'Data katalog berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $catalog = CatalogPrice::findOrFail($id);
            $catalog->delete();
            return redirect('/admin/katalog')->with('success', 'Kategori sampah berhasil dihapus dari sistem!');
        } catch (\Exception $e) {
            // PERBAIKAN: Mencegah aplikasi crash jika kategori masih dipakai di data transaksi
            return redirect('/admin/katalog')->withErrors(['error' => 'Gagal menghapus! Kategori ini sedang digunakan dalam transaksi.']);
        }
    }
}