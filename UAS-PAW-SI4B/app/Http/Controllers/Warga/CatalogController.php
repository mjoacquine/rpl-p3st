<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
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
        return view('Warga.Catalog.index', compact('catalogs'));
    }
}