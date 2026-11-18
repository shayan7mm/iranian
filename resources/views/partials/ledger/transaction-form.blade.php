{{--
    فرم تراکنش (ثبت و ویرایش) — مشترک بین اشخاص، ارگان‌ها، املاک و خودروها
    پارامترها: $transaction (برای ویرایش، وگرنه null)
               $withTitle (اختیاری: فیلد عنوان برای درآمد/هزینه), $incomeLabel, $expenseLabel
--}}
@php
    $t = $transaction ?? null;
    if ($t) {
        $dateValue = old('transaction_date') ? old('transaction_date') : $t->transaction_date;
        $typeValue = $t->isIncome() ? 'income' : ($t->isExpense() ? 'expense' : null);
    } else {
        // مقدار پیش‌فرض: تاریخ امروز به شمسی (مگر مقدار قبلی معتبر باشد)
        $oldDate = old('transaction_date');
        $dateValue = ($oldDate && preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $oldDate)) ? $oldDate : verta()->format('Y/m/d');
        $typeValue = old('type');
    }
@endphp
<div class="form-grid">
    @if (! empty($withTitle))
        <div class="field full">
            <label for="title">عنوان <span class="req">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $t?->title) }}" placeholder="مثال: خرید لوازم اداری" required>
            @error('title') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    @endif
    <div class="field full">
        <span class="label">نوع تراکنش <span class="req">*</span></span>
        <div class="segmented">
            <label class="income"><input type="radio" id="type_income" name="type" value="income" @checked($typeValue === 'income')> <x-icon name="arrow-down" /> {{ $incomeLabel ?? 'ورودی (دریافت)' }}</label>
            <label class="expense"><input type="radio" id="type_expense" name="type" value="expense" @checked($typeValue === 'expense')> <x-icon name="arrow-up" /> {{ $expenseLabel ?? 'خروجی (پرداخت)' }}</label>
        </div>
        @error('type') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="amount">مبلغ (تومان) <span class="req">*</span></label>
        <input type="number" id="amount" name="amount" value="{{ old('amount', $t?->amount) }}" placeholder="مبلغ را وارد کنید" min="1" dir="ltr" data-amount required>
        <span class="hint" data-amount-preview="amount"></span>
        @error('amount') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="transaction_date">{{ ! empty($withTitle) ? 'تاریخ' : 'تاریخ تراکنش' }} <span class="req">*</span></label>
        <input type="text" id="transaction_date" name="transaction_date" value="{{ $dateValue }}" placeholder="1404/06/25" dir="ltr" required>
        <span class="hint">فرمت شمسی: 1404/06/25</span>
        @error('transaction_date') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="from_account">شماره کارت / حساب مبدأ</label>
        <input type="text" id="from_account" name="from_account" value="{{ old('from_account', $t?->from_account) }}" placeholder="مثال: 6037-9910-0500-1234" dir="ltr">
        @error('from_account') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field">
        <label for="to_account">شماره کارت / حساب مقصد</label>
        <input type="text" id="to_account" name="to_account" value="{{ old('to_account', $t?->to_account) }}" placeholder="مثال: 6037-9910-0500-5678" dir="ltr">
        @error('to_account') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="field full">
        <label for="receipt_image">تصویر فیش واریزی</label>
        @if ($t && $t->receipt_image)
            <div class="actions" style="margin-bottom:4px">
                <img src="{{ asset($t->receipt_image) }}" alt="فیش فعلی" class="receipt-thumb">
                <span class="hint">فیش فعلی</span>
                <a href="{{ asset($t->receipt_image) }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm"><x-icon name="eye" /> مشاهده</a>
            </div>
        @endif
        <input type="file" id="receipt_image" name="receipt_image" accept="image/*">
        <span class="hint">حداکثر ۲ مگابایت{{ $t ? ' — برای تغییر، تصویر جدید انتخاب کنید' : '' }}</span>
        @error('receipt_image') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="field full">
        <label for="description">شرح / توضیحات</label>
        <textarea id="description" name="description" rows="3">{{ old('description', $t?->description) }}</textarea>
        @error('description') <span class="field-error">{{ $message }}</span> @enderror
    </div>
</div>
