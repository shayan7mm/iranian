<x-guest-layout title="تعیین رمز جدید">
    <h1>تعیین رمز عبور جدید</h1>
    <p class="lead">رمز عبور جدید حساب خود را وارد کنید.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="field">
            <label for="email">ایمیل</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" dir="ltr" required autofocus autocomplete="username">
            @foreach ($errors->get('email') as $message) <span class="field-error">{{ $message }}</span> @endforeach
        </div>
        <div class="field">
            <label for="password">رمز عبور جدید</label>
            <input id="password" type="password" name="password" dir="ltr" required autocomplete="new-password">
            @foreach ($errors->get('password') as $message) <span class="field-error">{{ $message }}</span> @endforeach
        </div>
        <div class="field">
            <label for="password_confirmation">تکرار رمز عبور</label>
            <input id="password_confirmation" type="password" name="password_confirmation" dir="ltr" required autocomplete="new-password">
            @foreach ($errors->get('password_confirmation') as $message) <span class="field-error">{{ $message }}</span> @endforeach
        </div>
        <button type="submit" class="btn btn-primary btn-block"><x-icon name="key" /> ذخیره رمز جدید</button>
    </form>
</x-guest-layout>
