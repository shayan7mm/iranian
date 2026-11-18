@extends('layouts.panel')

@section('title', 'اشخاص')
@section('heading', 'اشخاص')
@section('subheading', 'حساب‌های دریافتنی و پرداختنی اشخاص')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <span>اشخاص</span>
@endsection

@section('actions')
    <a href="{{ route('persons.create') }}" class="btn btn-primary"><x-icon name="plus" /> شخص جدید</a>
@endsection

@section('content')
    @include('partials.ledger.accounts', [
        'items' => $persons,
        'prefix' => 'persons',
        'icon' => 'user',
        'label' => 'شخص',
        'searchPlaceholder' => 'جستجوی نام شخص...',
        'meta' => fn ($i) => [['info', $i->description]],
        'links' => fn ($i) => [],
    ])
@endsection
