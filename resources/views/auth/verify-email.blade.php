<x-guest-layout title="تأیید ایمیل">
    <h1>تأیید ایمیل</h1>
    <p class="lead">پیش از شروع، لطفاً روی لینکی که به ایمیل شما ارسال شد کلیک کنید. اگر ایمیل را دریافت نکرده‌اید، دوباره ارسال می‌کنیم.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success"><x-icon name="check" /> <div>لینک تأیید جدید به ایمیل شما ارسال شد.</div></div>
    @endif

    <div class="actions" style="justify-content:space-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary"><x-icon name="mail" /> ارسال دوباره ایمیل تأیید</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-ghost"><x-icon name="logout" /> خروج</button>
        </form>
    </div>
</x-guest-layout>
