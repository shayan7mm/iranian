@extends('layouts.guest')

@section('title', 'ثبت‌نام')

@section('content')
    <h1>ثبت‌نام حسابدار</h1>
    <p class="lead">ایجاد حساب کاربری جدید در سیستم حسابداری ایرانیان</p>

    @if (session('error'))
        <div class="alert alert-error"><x-icon name="alert" /> <div>{{ session('error') }}</div></div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <x-icon name="alert" />
            <div>@foreach ($errors->all() as $error) {{ $error }}<br> @endforeach</div>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label for="name">نام کامل</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="نام و نام خانوادگی" required autofocus>
        </div>
        <div class="field">
            <label for="email">ایمیل</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" dir="ltr" required>
        </div>
        <div class="field">
            <label for="phone">شماره موبایل</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="09123456789" dir="ltr" required>
        </div>
        <div class="field">
            <label for="password">رمز عبور</label>
            <input type="password" id="password" name="password" placeholder="حداقل ۸ کاراکتر" dir="ltr" autocomplete="new-password" required>
        </div>
        <div class="field">
            <label for="password_confirmation">تکرار رمز عبور</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="تکرار رمز عبور" dir="ltr" autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg"><x-icon name="plus" /> ثبت‌نام در سیستم</button>
    </form>

    <div class="auth-links">
        <span class="muted">قبلاً ثبت‌نام کرده‌اید؟</span>
        <a href="{{ route('login') }}">ورود به سیستم</a>
    </div>
@endsection
