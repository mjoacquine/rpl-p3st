<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CatalogDao;

class CatalogController extends Controller
{
    protected $catalogDao;

    public function __construct(CatalogDao $catalogDao)
    {
        $this->catalogDao = $catalogDao;
    }

    public function index()
    {
        $catalogs = $this->catalogDao->getAllCategories();
        return view('Admin.Catalog.index', compact('catalogs'));
    }

    public function create()
    {
        return view('Admin.Catalog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
        ]);

        $this->catalogDao->create($data);
        return redirect()->route('admin.catalog.index')->with('success', 'Kategori sampah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $catalog = $this->catalogDao->findById($id);
        return view('Admin.Catalog.edit', compact('catalog'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
        ]);

        $this->catalogDao->update($id, $data);
        return redirect()->route('admin.catalog.index')->with('success', 'Katalog harga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->catalogDao->delete($id);
        return redirect()->route('admin.catalog.index')->with('success', 'Kategori berhasil dihapus.');
    }
}