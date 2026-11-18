{{--
    قالب صفحات ورود و احراز هویت حسابداری ایرانیان
    قابل استفاده به دو شکل: <x-guest-layout> (با $slot) یا @extends('layouts.guest') (با @section('content'))
--}}
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($attributes) ? $attributes->get('title', 'ورود') : View::getSection('title', 'ورود') }} | حسابداری ایرانیان</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Crect width='24' height='24' rx='6' fill='%230F7C77'/%3E%3Cpath d='M6 18V10l6-4 6 4v8M9 18v-5M12 18v-7M15 18v-3' stroke='%23F6EBD3' stroke-width='1.8' fill='none' stroke-linecap='round'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="{{ asset('css/iranian.css') }}?v={{ @filemtime(public_path('css/iranian.css')) }}">
</head>
<body>
<div class="auth">
    <aside class="auth-art">
        <a href="{{ url('/') }}" class="brand" style="border:none;padding:0">
            <span class="brand-mark"><x-icon name="logo" /></span>
            <span class="brand-text">
                <span class="brand-name">ایرانیان</span>
                <span class="brand-sub">سیستم حسابداری</span>
            </span>
        </a>
        <div>
            <h2>حساب‌ها، تراکنش‌ها و اقساط<br>در <span>یک دفتر یکپارچه</span></h2>
            <p>سیستم حسابداری ایرانیان برای ثبت دریافت و پرداخت، کارت مالی هر حساب، اقساط وام و اجاره و مدیریت دسترسی حسابداران.</p>
            <ul class="auth-points">
                <li><span class="dot"><x-icon name="ledger" class="icon icon-sm" /></span> کارت مالی جداگانه برای هر حساب</li>
                <li><span class="dot"><x-icon name="percent" class="icon icon-sm" /></span> پیگیری اقساط وام و اجاره</li>
                <li><span class="dot"><x-icon name="shield" class="icon icon-sm" /></span> سطح دسترسی برای هر حسابدار</li>
            </ul>
        </div>
        <div class="small" style="color:#6E9D99">© {{ verta()->format('Y') }} حسابداری ایرانیان</div>
    </aside>

    <main class="auth-panel">
        <div class="auth-card">
            <div class="auth-mobile-brand">
                <a href="{{ url('/') }}" class="brand">
                    <span class="brand-mark"><x-icon name="logo" /></span>
                    <span class="brand-text">
                        <span class="brand-name">ایرانیان</span>
                        <span class="brand-sub">سیستم حسابداری</span>
                    </span>
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </div>
            @hasSection('below')
                @yield('below')
            @endif
        </div>
    </main>
</div>
</body>
</html>
