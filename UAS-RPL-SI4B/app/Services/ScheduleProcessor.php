<?php
namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ScheduleProcessor
{
    public function createSchedule($userId, array $data)
    {
        $datePrefix = Carbon::now()->format('ymd');
        $randomStr = strtoupper(Str::random(4));
        $transactionId = 'TX-' . $datePrefix . '-' . $randomStr;

        return Transaction::create([
            'transaction_id' => $transactionId,
            'user_id' => $userId,
            'category_id' => $data['category_id'],
            'pickup_date' => Carbon::now()->addDay()->format('Y-m-d'),
            'weight_actual' => $data['weight_actual'] ?? 0,
            'price_final' => 0,
            'address' => $data['address'],
            'status' => 'menunggu',
        ]);
    }
}