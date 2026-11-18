<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
| ساخت اولین مدیر ارشد (master) یا ارتقای کاربر موجود به مدیر:
|   php artisan app:create-master
*/
Artisan::command('app:create-master', function () {
    $email = mb_strtolower(trim((string) $this->ask('ایمیل مدیر')));
    $user = \App\Models\User::firstWhere('email', $email);

    $name = $user?->name ?? (string) $this->ask('نام و نام خانوادگی');
    $phone = $user?->phone ?? (string) $this->ask('شماره موبایل (برای ورود با موبایل)');
    $password = (string) $this->secret('رمز عبور (حداقل ۸ کاراکتر)');
    $confirm = (string) $this->secret('تکرار رمز عبور');

    $validator = \Illuminate\Support\Facades\Validator::make(
        compact('email', 'name', 'phone', 'password') + ['password_confirmation' => $confirm],
        [
            'email' => ['required', 'email', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', \Illuminate\Validation\Rule::unique('users', 'phone')->ignore($user?->id)],
            'password' => ['required', 'confirmed', 'min:8'],
        ],
    );

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return 1;
    }

    $user ??= new \App\Models\User(['email' => $email]);
    $user->forceFill([
        'name' => $name,
        'phone' => $phone,
        'password' => \Illuminate\Support\Facades\Hash::make($password),
        'role' => 'master',
        'is_active' => true,
        'email_verified_at' => $user->email_verified_at ?? now(),
    ])->save();

    $this->info("مدیر ارشد «{$user->email}» آماده است. اکنون می‌توانید وارد سیستم شوید.");

    return 0;
})->purpose('ساخت مدیر ارشد (master) جدید یا ارتقای کاربر موجود');
