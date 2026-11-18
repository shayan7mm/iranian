{{--
    ⚠️ فیلد تاریخ همان کد قبلی صفحه ویرایش تراکنش خودرو است (بدون تغییر رفتار).
    این کد ایراد دارد: transaction_date در دیتابیس متن شمسی است و ->format() روی آن خطا می‌دهد،
    و ورودی type="date" تاریخ میلادی می‌فرستد که با اعتبارسنجی (1404/06/25) رد می‌شود.
    پس از تأیید مالک پروژه، این فایل حذف و فیلد تاریخ مشترک استفاده می‌شود.
--}}
<div class="field">
    <label for="transaction_date">تاریخ تراکنش <span class="req">*</span></label>
    <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required>
    @error('transaction_date') <span class="field-error">{{ $message }}</span> @enderror
</div>
