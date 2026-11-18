<?php

namespace App\Support;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

/**
 * بازسازی جدول اقساط (اجاره / وام) بدون از دست رفتن اقساط پرداخت‌شده.
 * اقساط پرداخت‌نشده از نو ساخته می‌شوند؛ اقساط پرداخت‌شده حفظ می‌شوند و فقط تاریخ سررسیدشان به‌روز می‌شود.
 */
class InstallmentSchedule
{
    /** بزرگ‌ترین شماره قسطِ پرداخت‌شده (برای جلوگیری از کم کردن مدت به کمتر از آن) */
    public static function lastPaidNumber(Model $plan): int
    {
        return (int) $plan->installments()->where('is_paid', true)->max('installment_number');
    }

    public static function sync(Model $plan): void
    {
        $paid = $plan->installments()->where('is_paid', true)->get()->keyBy('installment_number');
        $plan->installments()->where('is_paid', false)->delete();

        $startDate = Verta::parseFormat('Y/m/d', $plan->start_date);

        for ($i = 1; $i <= $plan->total_months; $i++) {
            $dueDate = $startDate->addMonths($i - 1)->format('Y/m/d');

            if ($paid->has($i)) {
                $paid[$i]->update(['due_date' => $dueDate]);
                continue;
            }

            $plan->installments()->create([
                'installment_number' => $i,
                'due_date' => $dueDate,
                'amount' => $plan->monthly_amount,
                'is_paid' => false,
            ]);
        }
    }
}
