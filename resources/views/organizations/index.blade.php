@extends('layouts.panel')

@section('title', 'ارگان‌ها و وام‌ها')
@section('heading', 'ارگان‌ها و وام‌ها')
@section('subheading', 'تراکنش‌ها و اقساط وام ارگان‌ها')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <span>ارگان‌ها و وام‌ها</span>
@endsection

@section('actions')
    <a href="{{ route('organizations.create') }}" class="btn btn-primary"><x-icon name="plus" /> ارگان جدید</a>
@endsection

@section('content')
    @include('partials.ledger.accounts', [
        'items' => $organizations,
        'prefix' => 'organizations',
        'icon' => 'bank',
        'label' => 'ارگان',
        'searchPlaceholder' => 'جستجوی نام ارگان...',
        'meta' => fn ($i) => [['info', $i->description]],
        'links' => fn ($i) => [[route('organizations.loans.index', $i), 'percent', 'وام‌ها']],
    ])
@endsection
