<x-guest-layout title="تأیید رمز عبور">
    <h1>تأیید رمز عبور</h1>
    <p class="lead">این بخش محافظت‌شده است. لطفاً برای ادامه، رمز عبور خود را تأیید کنید.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="field">
            <label for="password">رمز عبور</label>
            <input id="password" type="password" name="password" dir="ltr" required autocomplete="current-password">
            @foreach ($errors->get('password') as $message) <span class="field-error">{{ $message }}</span> @endforeach
        </div>
        <button type="submit" class="btn btn-primary btn-block"><x-icon name="check" /> تأیید</button>
    </form>
</x-guest-layout>
