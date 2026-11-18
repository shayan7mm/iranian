@extends('layouts.panel')

@section('title', 'ویرایش ملک')
@section('heading', 'ویرایش ملک')
@section('subheading', $house->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <span>ویرایش ملک</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('houses.update', $house) }}" class="card-body">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام ملک <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $house->name) }}" placeholder="مثال: آپارتمان خیابان ولیعصر" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="owner_name">نام صاحب ملک <span class="req">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name', $house->owner_name) }}" placeholder="نام و نام خانوادگی" required>
                    @error('owner_name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="owner_phone">شماره تماس صاحب ملک <span class="req">*</span></label>
                    <input type="text" id="owner_phone" name="owner_phone" value="{{ old('owner_phone', $house->owner_phone) }}" placeholder="09123456789" dir="ltr" required>
                    @error('owner_phone') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="address">آدرس کامل ملک <span class="req">*</span></label>
                    <textarea id="address" name="address" rows="3" required>{{ old('address', $house->address) }}</textarea>
                    @error('address') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="description">توضیحات</label>
                    <textarea id="description" name="description" rows="3">{{ old('description', $house->description) }}</textarea>
                    @error('description') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <span class="label">وضعیت ملک</span>
                    @php($st = old('status', $house->status))
                    <div class="segmented">
                        <label class="income"><input type="radio" id="status_active" name="status" value="active" @checked($st === 'active')> <x-icon name="check" /> فعال</label>
                        <label class="expense"><input type="radio" id="status_archived" name="status" value="archived" @checked($st === 'archived')> <x-icon name="archive" /> آرشیو</label>
                    </div>
                    @error('status') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('houses.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
