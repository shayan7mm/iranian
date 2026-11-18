@extends('layouts.panel')

@section('title', 'ویرایش وام')
@section('heading', 'ویرایش وام')
@section('subheading', $organization->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('organizations.index') }}">ارگان‌ها و وام‌ها</a> / <a href="{{ route('organizations.loans.index', $organization) }}">وام‌ها</a> / <span>ویرایش وام</span>
@endsection

@section('content')
    <div class="alert alert-info"><x-icon name="info" /> <div>با ذخیره، اقساط پرداخت‌نشده بر اساس مبلغ و تاریخ جدید از نو ساخته می‌شوند. اقساط پرداخت‌شده و تراکنش‌هایشان حفظ می‌شوند.</div></div>
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('organizations.loans.update', [$organization, $loan]) }}" class="card-body">
            @csrf
            @method('PUT')
            @include('partials.ledger.plan-form', ['plan' => $loan, 'isLoan' => true])
            <div class="form-actions">
                <a href="{{ route('organizations.loans.index', $organization) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
