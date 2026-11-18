@if (session('success'))
    <div class="alert alert-success" role="status"><x-icon name="check" /> <div>{{ session('success') }}</div></div>
@endif
@if (session('status') && ! in_array(session('status'), ['profile-updated', 'password-updated', 'verification-link-sent']))
    <div class="alert alert-info" role="status"><x-icon name="info" /> <div>{{ session('status') }}</div></div>
@endif
@if (session('error'))
    <div class="alert alert-error" role="alert"><x-icon name="alert" /> <div>{{ session('error') }}</div></div>
@endif
@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <x-icon name="alert" />
        <div>
            <strong>لطفاً موارد زیر را بررسی کنید:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
