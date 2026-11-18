{{--
    فرم قرارداد اقساطی (اجاره / وام)
    پارامترها: $plan (برای ویرایش، وگرنه null), $isLoan (bool)
--}}
@php
    $p = $plan ?? null;
    if ($isLoan) {
        $types = ['loan_given' => 'وام داده شده (ورودی)', 'loan_taken' => 'وام گرفته شده (خروجی)'];
        $typeValue = $p ? ($p->isLoanGiven() ? 'loan_given' : ($p->isLoanTaken() ? 'loan_taken' : null)) : old('type');
    } else {
        $types = ['rent_out' => 'اجاره داده شده (ورودی)', 'rent_in' => 'اجاره گرفته شده (خروجی)'];
        $typeValue = $p ? ($p->isRentOut() ? 'rent_out' : ($p->isRentIn() ? 'rent_in' : null)) : old('type');
    }
    $startValue = $p ? old('start_date', $p->start_date) : (old('start_date') ? old('start_date') : verta()->format('Y/m/d'));
    $word = $isLoan ? 'وام' : 'اجاره';
@endphp
<div class="form-grid">
    <div class="field full">
        <span class="label">نوع {{ $word }} <span class="req">*</span></span>
        <div class="segmented">
            @foreach ($types as $value => $text)
                <label class="{{ $loop->first ? 'income' : 'expense' }}">
                    <input type="radio" id="type_{{ $value }}" name="type" value="{{ $value }}" @checked($typeValue === $value)>
                    <x-icon :name="$loop->first ? 'arrow-down' : 'arrow-up'" /> {{ $text }}
                </label>
            @endforeach
        </div>
        @error('type') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    @if ($isLoan)
        <div class="field">
            <label for="total_amount">مبلغ کل وام (تومان) <span class="req">*</span></label>
            <input type="number" id="total_amount" name="total_amount" value="{{ old('total_amount', $p?->total_amount) }}" placeholder="مبلغ را وارد کنید" dir="ltr" data-amount required>
            <span class="hint" data-amount-preview="total_amount"></span>
            @error('total_amount') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    @endif

    <div class="field">
        <label for="monthly_amount">{{ $isLoan ? 'مبلغ هر قسط (تومان)' : 'مبلغ اجاره ماهیانه (تومان)' }} <span class="req">*</span></label>
        <input type="number" id="monthly_amount" name="monthly_amount" value="{{ old('monthly_amount', $p?->monthly_amount) }}" placeholder="مبلغ را وارد کنید" dir="ltr" data-amount required>
        <span class="hint" data-amount-preview="monthly_amount"></span>
        @error('monthly_amount') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="start_date">تاریخ شروع {{ $word }} <span class="req">*</span></label>
        <input type="text" id="start_date" name="start_date" value="{{ $startValue }}" placeholder="1404/06/25" dir="ltr" required>
        <span class="hint">فرمت شمسی: 1404/06/25</span>
        @error('start_date') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label for="total_months">تعداد ماه‌های {{ $word }} <span class="req">*</span></label>
        <input type="number" id="total_months" name="total_months" value="{{ old('total_months', $p?->total_months ?? 12) }}" min="1" max="60" dir="ltr" required>
        <span class="hint">حداکثر ۶۰ ماه</span>
        @error('total_months') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    @if ($p)
        <div class="field full">
            <span class="label">وضعیت {{ $word }}</span>
            <div class="segmented">
                <label class="income"><input type="radio" id="status_active" name="status" value="active" @checked($p->isActive())> فعال</label>
                <label><input type="radio" id="status_completed" name="status" value="completed" @checked($p->isCompleted())> تکمیل شده</label>
                <label class="expense"><input type="radio" id="status_cancelled" name="status" value="cancelled" @checked($p->status == 'cancelled')> لغو شده</label>
            </div>
            @error('status') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    @endif
</div>
