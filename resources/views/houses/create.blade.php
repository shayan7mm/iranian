@extends('layouts.panel')

@section('title', 'ملک جدید')
@section('heading', 'ثبت ملک جدید')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <span>ملک جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('houses.store') }}" class="card-body">
            @csrf
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام ملک <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="مثال: آپارتمان خیابان ولیعصر" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="owner_name">نام صاحب ملک <span class="req">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}" placeholder="نام و نام خانوادگی" required>
                    @error('owner_name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="owner_phone">شماره تماس صاحب ملک <span class="req">*</span></label>
                    <input type="text" id="owner_phone" name="owner_phone" value="{{ old('owner_phone') }}" placeholder="09123456789" dir="ltr" required>
                    @error('owner_phone') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="address">آدرس کامل ملک <span class="req">*</span></label>
                    <textarea id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    @error('address') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="description">توضیحات</label>
                    <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('houses.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت ملک</button>
            </div>
        </form>
    </div>
@endsection
