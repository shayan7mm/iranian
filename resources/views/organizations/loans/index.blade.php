@extends('layouts.panel')

@section('title', 'وام‌ها')
@section('heading', 'وام‌های ' . $organization->name)
@section('subheading', 'اقساط وام و وضعیت پرداخت')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('organizations.index') }}">ارگان‌ها و وام‌ها</a> / <span>وام‌ها</span>
@endsection

@section('actions')
    <a href="{{ route('organizations.transactions.index', $organization) }}" class="btn btn-outline"><x-icon name="ledger" /> کارت مالی</a>
    <a href="{{ route('organizations.loans.create', $organization) }}" class="btn btn-primary"><x-icon name="plus" /> وام جدید</a>
@endsection

@section('content')
    @include('partials.ledger.installment-plans', [
        'plans' => $loans,
        'route' => 'organizations.loans',
        'owner' => $organization,
        'isLoan' => true,
        'canCancel' => true,
        'emptyText' => 'هیچ وامی برای این ارگان ثبت نشده است',
    ])

    {{ $loans->appends(request()->query())->links('partials.pagination') }}
@endsection
