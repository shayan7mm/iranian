<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دسترسی غیرمجاز | حسابداری ایرانیان</title>
    <link rel="stylesheet" href="{{ asset('css/iranian.css') }}">
</head>
<body>
<div class="error-page">
    <div class="card" style="max-width:460px;width:100%">
        <div class="card-body">
            <div class="code">403</div>
            <h1 style="font-size:20px;margin-bottom:6px">دسترسی غیرمجاز</h1>
            <p class="muted" style="margin-bottom:18px">{{ $exception->getMessage() ?: 'شما اجازه دسترسی به این بخش را ندارید.' }}</p>
            <a href="{{ url('/') }}" class="btn btn-primary">بازگشت به صفحه نخست</a>
        </div>
    </div>
</div>
</body>
</html>
