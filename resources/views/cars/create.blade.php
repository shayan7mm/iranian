@extends('layouts.panel')

@section('title', 'خودرو جدید')
@section('heading', 'ثبت خودرو جدید')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('cars.index') }}">خودروها</a> / <span>خودرو جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('cars.store') }}" class="card-body">
            @csrf
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام خودرو <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="مثال: پراید سفید" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="owner_name">نام صاحب خودرو <span class="req">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}" placeholder="نام و نام خانوادگی" required>
                    @error('owner_name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="owner_phone">شماره تماس صاحب خودرو <span class="req">*</span></label>
                    <input type="text" id="owner_phone" name="owner_phone" value="{{ old('owner_phone') }}" placeholder="09123456789" dir="ltr" required>
                    @error('owner_phone') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="description">توضیحات</label>
                    <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('cars.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت خودرو</button>
            </div>
        </form>
    </div>
@endsection
