<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم حسابداری ایرانیان</title>
    <meta name="description" content="سیستم حسابداری ایرانیان؛ ثبت دریافت و پرداخت، کارت مالی حساب‌ها، اقساط وام و اجاره و مدیریت دسترسی حسابداران.">
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Crect width='24' height='24' rx='6' fill='%230F7C77'/%3E%3Cpath d='M6 18V10l6-4 6 4v8M9 18v-5M12 18v-7M15 18v-3' stroke='%23F6EBD3' stroke-width='1.8' fill='none' stroke-linecap='round'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="{{ asset('css/iranian.css') }}?v={{ @filemtime(public_path('css/iranian.css')) }}">
</head>
<body>
<div class="landing-wrap">
    <header class="landing-nav">
        <a href="{{ url('/') }}" class="brand">
            <span class="brand-mark"><x-icon name="logo" /></span>
            <span class="brand-text">
                <span class="brand-name">ایرانیان</span>
                <span class="brand-sub">سیستم حسابداری</span>
            </span>
        </a>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary"><x-icon name="dashboard" /> ورود به داشبورد</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary"><x-icon name="login" /> ورود به سیستم</a>
        @endauth
    </header>

    <section class="hero">
        <div>
            <span class="eyebrow"><x-icon name="shield" class="icon icon-sm" /> حسابداری امن و یکپارچه</span>
            <h1>به <span>سیستم حسابداری ایرانیان</span> خوش آمدید</h1>
            <p>
                دریافت‌ها و پرداخت‌های اشخاص، ارگان‌ها، املاک و خودروها را در یک دفتر ثبت کنید،
                اقساط وام و اجاره را پیگیری کنید و برای هر حسابدار سطح دسترسی جداگانه تعیین کنید.
            </p>
            <div class="hero-cta">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-gold btn-lg"><x-icon name="dashboard" /> ورود به داشبورد</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold btn-lg"><x-icon name="login" /> ورود به سیستم</a>
                @endauth
            </div>
        </div>
        <div class="ledger-mock" aria-hidden="true">
            <div class="lm-head"><span>کارت مالی نمونه</span><span class="badge badge-brand">{{ verta()->format('%B %Y') }}</span></div>
            <div class="lm-row"><span>دریافت اجاره ماهانه</span><span class="amount-income num">۱۸,۰۰۰,۰۰۰+</span></div>
            <div class="lm-row"><span>قسط وام بانکی</span><span class="amount-expense num">۷,۵۰۰,۰۰۰−</span></div>
            <div class="lm-row"><span>هزینه تعمیرات</span><span class="amount-expense num">۲,۲۰۰,۰۰۰−</span></div>
            <div class="lm-row"><span>تسویه حساب شخص</span><span class="amount-income num">۴,۰۰۰,۰۰۰+</span></div>
            <div class="lm-total"><span>مانده</span><span class="num">۱۲,۳۰۰,۰۰۰ تومان</span></div>
        </div>
    </section>

    <section class="features">
        <div class="feature">
            <div class="f-icon"><x-icon name="ledger" /></div>
            <h3>دفاتر یکپارچه</h3>
            <p>اشخاص، ارگان‌ها، املاک، خودروها و هزینه‌های جانبی در یک پنل</p>
        </div>
        <div class="feature">
            <div class="f-icon"><x-icon name="receipt" /></div>
            <h3>ثبت دقیق تراکنش</h3>
            <p>مبلغ، تاریخ شمسی، کارت مبدأ و مقصد و تصویر فیش برای هر تراکنش</p>
        </div>
        <div class="feature">
            <div class="f-icon"><x-icon name="percent" /></div>
            <h3>اقساط وام و اجاره</h3>
            <p>ساخت خودکار اقساط، ثبت پرداخت و نمایش پیشرفت بازپرداخت</p>
        </div>
        <div class="feature">
            <div class="f-icon"><x-icon name="shield" /></div>
            <h3>دسترسی حسابداران</h3>
            <p>تعیین دسترسی هر حسابدار به بخش‌ها و آیتم‌های مشخص</p>
        </div>
    </section>

    <footer class="landing-foot">
        سیستم حسابداری ایرانیان © {{ verta()->format('Y') }}
        <span style="margin:0 8px;color:var(--ink-300)">|</span>
        طراحی و توسعه توسط تیم <a href="https://shayanwebmaster.ir" rel="noopener">شایان وب مستر</a>
    </footer>
</div>
</body>
</html>
