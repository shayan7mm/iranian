@extends('layouts.panel')

@php
    $u = auth()->user();
    $modules = [
        'persons'       => ['route' => 'persons.index',       'icon' => 'users',   'title' => 'اشخاص',          'sub' => 'حساب‌های اشخاص'],
        'organizations' => ['route' => 'organizations.index', 'icon' => 'bank',    'title' => 'ارگان‌ها و وام‌ها', 'sub' => 'تراکنش و اقساط وام'],
        'houses'        => ['route' => 'houses.index',        'icon' => 'home',    'title' => 'املاک و اجاره',   'sub' => 'تراکنش و اقساط اجاره'],
        'cars'          => ['route' => 'cars.index',          'icon' => 'car',     'title' => 'خودروها',        'sub' => 'کارت مالی خودروها'],
        'expenses'      => ['route' => 'expenses.index',      'icon' => 'receipt', 'title' => 'درآمد و هزینه',   'sub' => 'هزینه‌های جانبی'],
    ];
    $allowed = array_filter($modules, fn ($key) => $u->hasModuleAccess($key), ARRAY_FILTER_USE_KEY);
@endphp

@section('title', 'داشبورد')
@section('heading', $u->name . ' عزیز، خوش آمدید')
@section('subheading', 'پنل حسابدار — ' . verta()->format('%A %d %B %Y'))

@section('content')
    <div class="stats">
        <div class="stat gold">
            <div class="stat-icon"><x-icon name="calendar" /></div>
            <div>
                <div class="stat-label">امروز</div>
                <div class="stat-value">{{ verta()->format('%d %B') }}</div>
                <div class="stat-meta">{{ verta()->format('%A، %Y') }}</div>
            </div>
        </div>
        <div class="stat">
            <div class="stat-icon"><x-icon name="user" /></div>
            <div style="min-width:0">
                <div class="stat-label">نام کاربری</div>
                <div class="stat-value" style="font-size:16px">{{ $u->name }}</div>
            </div>
        </div>
        <div class="stat">
            <div class="stat-icon"><x-icon name="mail" /></div>
            <div style="min-width:0">
                <div class="stat-label">ایمیل</div>
                <div class="stat-value ltr" style="font-size:14px">{{ $u->email }}</div>
            </div>
        </div>
        <div class="stat">
            <div class="stat-icon"><x-icon name="phone" /></div>
            <div>
                <div class="stat-label">شماره موبایل</div>
                <div class="stat-value ltr" style="font-size:16px">{{ $u->phone ?: '—' }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head"><h2><x-icon name="ledger" /> بخش‌های قابل دسترس</h2></div>
        <div class="card-body">
            @if (count($allowed))
                <div class="shortcuts">
                    @foreach ($allowed as $m)
                        <a href="{{ route($m['route']) }}" class="shortcut">
                            <span class="s-icon"><x-icon :name="$m['icon']" /></span>
                            <span class="s-title">{{ $m['title'] }}</span>
                            <span class="s-sub">{{ $m['sub'] }}</span>
                        </a>
                    @endforeach
                    <a href="{{ route('profile.edit') }}" class="shortcut gold">
                        <span class="s-icon"><x-icon name="user" /></span>
                        <span class="s-title">ویرایش پروفایل</span>
                        <span class="s-sub">نام و رمز عبور</span>
                    </a>
                </div>
            @else
                <div class="empty">
                    <div class="empty-icon"><x-icon name="key" /></div>
                    <h3>شما به هیچ بخشی دسترسی ندارید</h3>
                    <p>برای دریافت دسترسی با مدیر سیستم تماس بگیرید.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline"><x-icon name="user" /> ویرایش پروفایل</a>
                </div>
            @endif
        </div>
    </div>
@endsection
