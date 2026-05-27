<?php
namespace App\Services;

use App\Models\Transaction;

class MonthlyReport
{
    public static function getSummary($month, $year)
    {
        return Transaction::whereMonth('created_at', $month)
                          ->whereYear('created_at', $year)
                          ->where('status', 'selesai')
                          ->selectRaw('
                              SUM(price_final) as total_income, 
                              SUM(weight_actual) as total_weight,
                              COUNT(transaction_id) as total_transactions
                          ')
                          ->first();
    }

    public static function getDetail($month, $year)
    {
        return Transaction::whereMonth('created_at', $month)
                          ->whereYear('created_at', $year)
                          ->with(['user', 'catalogPrice'])
                          ->latest()
                          ->get();
    }
}