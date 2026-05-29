<?php

namespace App\Repositories;

use App\Models\CatalogPrice;

class CatalogDao
{
    public function getAllCategories()
    {
        return CatalogPrice::orderBy('category_name', 'asc')->get();
    }

    public function findById($id)
    {
        return CatalogPrice::findOrFail($id);
    }

    public function create(array $data)
    {
        return CatalogPrice::create($data);
    }

    public function update($id, array $data)
    {
        $catalog = $this->findById($id);
        $catalog->update($data);
        return $catalog;
    }

    public function delete($id)
    {
        $catalog = $this->findById($id);
        return $catalog->delete();
    }
}