@extends('layouts.panel')

@section('title', 'ویرایش وام')
@section('heading', 'ویرایش وام')
@section('subheading', $organization->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('organizations.index') }}">ارگان‌ها و وام‌ها</a> / <a href="{{ route('organizations.loans.index', $organization) }}">وام‌ها</a> / <span>ویرایش وام</span>
@endsection

@section('content')
    <div class="alert alert-warn"><x-icon name="alert" /> <div>توجه: با ذخیره این فرم، همه اقساط از نو ساخته می‌شوند و وضعیت «پرداخت شده» اقساط قبلی پاک می‌شود.</div></div>
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
