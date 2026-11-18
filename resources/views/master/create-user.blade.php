@extends('layouts.panel')

@section('title', 'حسابدار جدید')
@section('heading', 'ثبت حسابدار جدید')
@section('subheading', 'حساب کاربری جدید با نقش حسابدار ساخته می‌شود')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('master.users') }}">کاربران</a> / <span>حسابدار جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:760px">
        <form method="POST" action="{{ route('master.users.store') }}" class="card-body">
            @csrf
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام کامل <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="نام و نام خانوادگی" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="email">ایمیل <span class="req">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" dir="ltr" required>
                    @error('email') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="phone">شماره موبایل <span class="req">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="09123456789" dir="ltr" required>
                    @error('phone') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="password">رمز عبور <span class="req">*</span></label>
                    <input type="password" id="password" name="password" placeholder="حداقل ۸ کاراکتر" autocomplete="new-password" required>
                    <span class="hint">حداقل ۸ کاراکتر</span>
                    @error('password') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="password_confirmation">تکرار رمز عبور <span class="req">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="تکرار رمز عبور" autocomplete="new-password" required>
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('master.users') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت حسابدار</button>
            </div>
        </form>
    </div>
@endsection
