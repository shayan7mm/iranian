@extends('layouts.panel')

@section('title', 'پروفایل من')
@section('heading', 'پروفایل من')
@section('subheading', 'اطلاعات حساب کاربری و رمز عبور')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <span>پروفایل</span>
@endsection

@section('content')
    @if (session('status') == 'profile-updated')
        <div class="alert alert-success"><x-icon name="check" /> <div>اطلاعات با موفقیت به‌روزرسانی شد.</div></div>
    @endif
    @if (session('status') == 'password-updated')
        <div class="alert alert-success"><x-icon name="check" /> <div>رمز عبور با موفقیت تغییر کرد.</div></div>
    @endif

    <div class="split">
        <div>
            <div class="card">
                <div class="card-head"><h2><x-icon name="user" /> اطلاعات حساب</h2></div>
                <form method="POST" action="{{ route('profile.update') }}" class="card-body">
                    @csrf
                    @method('patch')
                    <div class="form-grid">
                        <div class="field full">
                            <label for="name">نام کامل <span class="req">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        @if (auth()->user()->isMaster())
                            <div class="field">
                                <label for="email">ایمیل <span class="req">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" dir="ltr" required>
                                @error('email') <span class="field-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="field">
                                <label for="phone">شماره موبایل <span class="req">*</span></label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" dir="ltr" required>
                                @error('phone') <span class="field-error">{{ $message }}</span> @enderror
                            </div>
                        @else
                            {{-- حسابدار فقط نام و رمز عبور را می‌تواند ویرایش کند --}}
                            <div class="field">
                                <label for="email">ایمیل</label>
                                <input type="email" id="email" value="{{ $user->email }}" dir="ltr" disabled>
                                <span class="hint">تغییر ایمیل فقط توسط مدیر امکان‌پذیر است.</span>
                                @error('email') <span class="field-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="field">
                                <label for="phone">شماره موبایل</label>
                                <input type="text" id="phone" value="{{ $user->phone }}" dir="ltr" disabled>
                                <span class="hint">تغییر شماره موبایل فقط توسط مدیر امکان‌پذیر است.</span>
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-head"><h2><x-icon name="key" /> تغییر رمز عبور</h2></div>
                <form method="POST" action="{{ route('profile.password.update') }}" class="card-body">
                    @csrf
                    @method('put')
                    <div class="form-grid">
                        <div class="field full">
                            <label for="current_password">رمز عبور فعلی <span class="req">*</span></label>
                            <input type="password" id="current_password" name="current_password" autocomplete="current-password" required>
                            @error('current_password') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field">
                            <label for="password">رمز عبور جدید <span class="req">*</span></label>
                            <input type="password" id="password" name="password" placeholder="حداقل ۸ کاراکتر" autocomplete="new-password" required>
                            @error('password') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field">
                            <label for="password_confirmation">تکرار رمز عبور جدید <span class="req">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-gold"><x-icon name="key" /> تغییر رمز عبور</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="text-align:center">
                <div class="avatar" style="width:72px;height:72px;font-size:28px;margin:0 auto 10px">{{ mb_substr($user->name, 0, 1) }}</div>
                <div style="font-weight:800;font-size:16px">{{ $user->name }}</div>
                <span class="badge {{ $user->isMaster() ? 'badge-gold' : 'badge-brand' }}">{{ $user->isMaster() ? 'مدیر ارشد' : 'حسابدار' }}</span>
                <dl class="dl" style="margin-top:18px;text-align:right">
                    <dt>ایمیل</dt><dd class="ltr">{{ $user->email }}</dd>
                    <dt>موبایل</dt><dd class="ltr">{{ $user->phone ?: '—' }}</dd>
                    <dt>عضویت</dt><dd>{{ verta($user->created_at)->format('%d %B %Y') }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
