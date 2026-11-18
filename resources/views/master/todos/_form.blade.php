<div class="form-grid">
    <div class="field full">
        <label for="title">عنوان کار <span class="req">*</span></label>
        <input type="text" id="title" name="title" value="{{ old('title', $todo->title ?? '') }}" placeholder="عنوان کار را وارد کنید" required>
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field full">
        <label for="description">توضیحات</label>
        <textarea id="description" name="description" rows="3">{{ old('description', $todo->description ?? '') }}</textarea>
        @error('description') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field">
        <label for="due_date">تاریخ سررسید</label>
        <input type="text" id="due_date" name="due_date" value="{{ old('due_date', $todo->due_date ?? '') }}" placeholder="مثال: 1404/06/25" dir="ltr">
        <span class="hint">اختیاری — به هر شکلی که مایلید وارد کنید.</span>
        @error('due_date') <span class="field-error">{{ $message }}</span> @enderror
    </div>
</div>
