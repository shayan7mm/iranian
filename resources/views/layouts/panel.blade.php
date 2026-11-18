{{--
    قالب اصلی پنل حسابداری ایرانیان
    بخش‌ها: title (عنوان تب)، heading، subheading، crumbs، actions، content
--}}
@php
    $authUser = auth()->user();
    $isMaster = $authUser->isMaster();
    $initial = mb_substr($authUser->name, 0, 1);
    $navItems = [
        ['route' => 'persons.index',       'match' => 'persons.*',       'icon' => 'users',    'label' => 'اشخاص',            'module' => 'persons'],
        ['route' => 'organizations.index', 'match' => 'organizations.*', 'icon' => 'bank',     'label' => 'ارگان‌ها و وام‌ها',  'module' => 'organizations'],
        ['route' => 'houses.index',        'match' => 'houses.*',        'icon' => 'home',     'label' => 'املاک و اجاره',     'module' => 'houses'],
        ['route' => 'cars.index',          'match' => 'cars.*',          'icon' => 'car',      'label' => 'خودروها',          'module' => 'cars'],
        ['route' => 'expenses.index',      'match' => 'expenses.*',      'icon' => 'receipt',  'label' => 'درآمد و هزینه',     'module' => 'expenses'],
    ];
@endphp
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'پنل') | حسابداری ایرانیان</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Crect width='24' height='24' rx='6' fill='%230F7C77'/%3E%3Cpath d='M6 18V10l6-4 6 4v8M9 18v-5M12 18v-7M15 18v-3' stroke='%23F6EBD3' stroke-width='1.8' fill='none' stroke-linecap='round'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="{{ asset('css/iranian.css') }}?v={{ @filemtime(public_path('css/iranian.css')) }}">
    @stack('head')
</head>
<body data-layout="panel">
<div class="app">
    <aside class="sidebar" id="sidebar" aria-label="منوی اصلی">
        <a href="{{ route('dashboard') }}" class="brand">
            <span class="brand-mark"><x-icon name="logo" /></span>
            <span class="brand-text">
                <span class="brand-name">ایرانیان</span>
                <span class="brand-sub">سیستم حسابداری</span>
            </span>
        </a>

        <nav class="nav">
            <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>
                <x-icon name="dashboard" /> داشبورد
            </a>

            <div class="nav-label">حساب‌ها و دفاتر</div>
            @foreach ($navItems as $item)
                @if ($isMaster || $authUser->hasModuleAccess($item['module']))
                    <a href="{{ route($item['route']) }}" @class(['active' => request()->routeIs($item['match'])])>
                        <x-icon :name="$item['icon']" /> {{ $item['label'] }}
                    </a>
                @endif
            @endforeach

            @if ($isMaster)
                <div class="nav-label">مدیریت سیستم</div>
                <a href="{{ route('master.users') }}" @class(['active' => request()->routeIs('master.users*', 'permissions.*', 'register')])>
                    <x-icon name="shield" /> کاربران و دسترسی‌ها
                </a>
                <a href="{{ route('master.todos.index') }}" @class(['active' => request()->routeIs('master.todos.*')])>
                    <x-icon name="checklist" /> کارهای روزانه
                </a>
            @endif

            <div class="nav-label">حساب کاربری</div>
            <a href="{{ route('profile.edit') }}" @class(['active' => request()->routeIs('profile.*')])>
                <x-icon name="user" /> پروفایل من
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-logout"><x-icon name="logout" /> خروج از حساب</button>
            </form>
        </nav>

        <div class="sidebar-foot">حسابداری ایرانیان © {{ verta()->format('Y') }}</div>
    </aside>
    <div class="backdrop" data-close-sidebar></div>

    <div class="main">
        <header class="topbar">
            <button type="button" class="btn btn-ghost btn-sm menu-btn" data-toggle-sidebar aria-label="باز کردن منو">
                <x-icon name="menu" />
            </button>
            <div class="topbar-date"><x-icon name="calendar" class="icon icon-sm" /> {{ verta()->format('l j F Y') }}</div>
            <div class="topbar-spacer"></div>
            <a href="{{ route('profile.edit') }}" class="user-chip" title="پروفایل">
                <span class="avatar">{{ $initial }}</span>
                <span class="meta">
                    <span class="name" style="display:block;color:var(--ink-900)">{{ $authUser->name }}</span>
                    <span class="role">{{ $isMaster ? 'مدیر ارشد' : 'حسابدار' }}</span>
                </span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline-form">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm" title="خروج"><x-icon name="logout" /></button>
            </form>
        </header>

        <main class="content">
            <div class="page-head">
                <div>
                    @hasSection('crumbs')
                        <div class="crumbs">@yield('crumbs')</div>
                    @endif
                    <h1>@yield('heading', View::getSection('title'))</h1>
                    @hasSection('subheading')
                        <div class="sub">@yield('subheading')</div>
                    @endif
                </div>
                @hasSection('actions')
                    <div class="page-actions">@yield('actions')</div>
                @endif
            </div>

            @include('partials.flash')

            @yield('content')
        </main>

        <footer class="app-footer">سیستم حسابداری ایرانیان</footer>
    </div>
</div>
<script src="{{ asset('js/iranian.js') }}?v={{ @filemtime(public_path('js/iranian.js')) }}"></script>
@stack('scripts')
</body>
</html>
