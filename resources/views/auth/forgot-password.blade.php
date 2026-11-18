<x-guest-layout title="فراموشی رمز عبور">
    <h1>فراموشی رمز عبور</h1>
    <p class="lead">ایمیل حساب خود را وارد کنید تا لینک تعیین رمز جدید برایتان ارسال شود.</p>

    @if (session('status'))
        <div class="alert alert-success"><x-icon name="check" /> <div>{{ session('status') }}</div></div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="field">
            <label for="email">ایمیل</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" dir="ltr" required autofocus>
            @foreach ($errors->get('email') as $message) <span class="field-error">{{ $message }}</span> @endforeach
        </div>
        <button type="submit" class="btn btn-primary btn-block"><x-icon name="mail" /> ارسال لینک بازیابی رمز</button>
    </form>

    <div class="auth-links"><a href="{{ route('login') }}">بازگشت به ورود</a></div>
</x-guest-layout>
