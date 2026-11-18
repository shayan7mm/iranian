@extends('layouts.panel')

@section('title', 'ویرایش حسابدار')
@section('heading', 'ویرایش حسابدار')
@section('subheading', $user->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('master.users') }}">کاربران</a> / <span>ویرایش</span>
@endsection

@section('actions')
    <a href="{{ route('permissions.index', $user) }}" class="btn btn-warn"><x-icon name="key" /> دسترسی‌ها</a>
@endsection

@section('content')
    <div class="card" style="max-width:760px">
        <form method="POST" action="{{ route('master.users.update', $user) }}" class="card-body">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام کامل <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="email">ایمیل <span class="req">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" dir="ltr" required>
                    @error('email') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="phone">شماره موبایل <span class="req">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" dir="ltr" required>
                    @error('phone') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <span class="label">وضعیت حساب</span>
                    @php($active = (string) old('is_active', $user->is_active ? '1' : '0'))
                    <div class="segmented">
                        <label class="income"><input type="radio" name="is_active" value="1" @checked($active === '1')> <x-icon name="check" /> فعال</label>
                        <label class="expense"><input type="radio" name="is_active" value="0" @checked($active === '0')> <x-icon name="x" /> غیرفعال</label>
                    </div>
                    @error('is_active') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-section"><x-icon name="key" /> تغییر رمز عبور (اختیاری)</div>
                <div class="field">
                    <label for="password">رمز عبور جدید</label>
                    <input type="password" id="password" name="password" placeholder="برای تغییر رمز پر کنید" autocomplete="new-password">
                    <span class="hint">در غیر این صورت خالی بگذارید.</span>
                    @error('password') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="password_confirmation">تکرار رمز عبور جدید</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="تکرار رمز عبور جدید" autocomplete="new-password">
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('master.users') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
