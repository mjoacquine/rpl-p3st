<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CatalogDAO
{
    /**
     * Menambah rekaman data baru (CRUD) ke tabel catalog_prices.
     */
    public function insert(array $data): bool
    {
        return DB::table('catalog_prices')->insert($data);
    }

    /**
     * Menjalankan kueri pengambilan semua data dari katalog harga.
     */
    public function selectAll(): array
    {
        return DB::table('catalog_prices')->get()->toArray();
    }

    /**
     * Mengambil satu data kategori berdasarkan ID.
     */
    public function selectById(string $categoryId): ?object
    {
        return DB::table('catalog_prices')
            ->where('category_id', $categoryId)
            ->first();
    }

    /**
     * Memperbarui data katalog (Tambahan agar CRUD sempurna).
     */
    public function update(string $categoryId, array $data): int
    {
        return DB::table('catalog_prices')
            ->where('category_id', $categoryId)
            ->update($data);
    }

    /**
     * Menghapus rekaman data tertentu dari tabel basis data.
     */
    public function delete(string $categoryId): int
    {
        return DB::table('catalog_prices')
            ->where('category_id', $categoryId)
            ->delete();
    }
}