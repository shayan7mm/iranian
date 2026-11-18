@extends('layouts.guest')

@section('title', 'ورود')

@section('content')
    <h1>ورود به حساب</h1>
    <p class="lead">برای ورود، ایمیل یا شماره موبایل و رمز عبور خود را وارد کنید.</p>

    @if (session('status'))
        <div class="alert alert-info"><x-icon name="info" /> <div>{{ session('status') }}</div></div>
    @endif

    @if ($errors->has('login'))
        <div class="alert alert-error"><x-icon name="alert" /> <div>{{ $errors->first('login') }}</div></div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <label for="login">ایمیل یا شماره موبایل</label>
            <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="email@example.com / 0912xxxxxxx" dir="ltr" required autofocus autocomplete="username">
        </div>
        <div class="field">
            <label for="password">رمز عبور</label>
            <input type="password" id="password" name="password" placeholder="رمز عبور" dir="ltr" required autocomplete="current-password">
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:6px"><x-icon name="login" /> ورود به سیستم</button>
    </form>

    <div class="auth-links">
        <a href="{{ route('password.request') }}">رمز عبور را فراموش کرده‌اید؟</a>
        <a href="{{ url('/') }}" class="muted">بازگشت به صفحه نخست</a>
    </div>
@endsection
