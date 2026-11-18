@extends('layouts.panel')

@section('title', 'وام جدید')
@section('heading', 'ثبت وام جدید')
@section('subheading', $organization->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('organizations.index') }}">ارگان‌ها و وام‌ها</a> / <a href="{{ route('organizations.loans.index', $organization) }}">وام‌ها</a> / <span>وام جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('organizations.loans.store', $organization) }}" class="card-body">
            @csrf
            @include('partials.ledger.plan-form', ['plan' => null, 'isLoan' => true])
            <div class="form-actions">
                <a href="{{ route('organizations.loans.index', $organization) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت وام</button>
            </div>
        </form>
    </div>
@endsection
