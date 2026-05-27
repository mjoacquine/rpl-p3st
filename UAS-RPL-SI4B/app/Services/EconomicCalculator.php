<?php
namespace App\Services;

use App\Repositories\CatalogDAO;

class EconomicCalculator
{
    protected $catalogDAO;

    public function __construct(CatalogDAO $catalogDAO)
    {
        $this->catalogDAO = $catalogDAO;
    }

    public function calculateEstimate(string $categoryId, float $estimatedWeight): float
    {
        $catalog = $this->catalogDAO->selectById($categoryId);
        if (!$catalog) return 0.00;
        return $estimatedWeight * $catalog->price;
    }

    public function calculateFinalPrice(string $categoryId, float $actualWeight): float
    {
        $catalog = $this->catalogDAO->selectById($categoryId);
        if (!$catalog) return 0.00;
        return $actualWeight * $catalog->price;
    }
}