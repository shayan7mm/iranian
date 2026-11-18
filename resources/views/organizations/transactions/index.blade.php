@extends('layouts.panel')

@section('title', 'کارت مالی')
@section('heading', 'کارت مالی: ' . $organization->name)
@section('subheading', 'کارت مالی ارگان')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('organizations.index') }}">ارگان‌ها و وام‌ها</a> / <span>کارت مالی</span>
@endsection

@section('actions')
    <a href="{{ route('organizations.transactions.create', $organization) }}" class="btn btn-primary"><x-icon name="plus" /> تراکنش جدید</a>
@endsection

@section('content')
    @include('partials.ledger.transactions', [
        'prefix' => 'organizations',
        'owner' => $organization,
        'ownerLabel' => 'ارگان',
    ])
@endsection
