@extends('layouts.panel')

@section('title', 'خودروها')
@section('heading', 'خودروها')
@section('subheading', 'کارت مالی و تراکنش‌های خودروها')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <span>خودروها</span>
@endsection

@section('actions')
    <a href="{{ route('cars.create') }}" class="btn btn-primary"><x-icon name="plus" /> خودرو جدید</a>
@endsection

@section('content')
    @include('partials.ledger.accounts', [
        'items' => $cars,
        'prefix' => 'cars',
        'icon' => 'car',
        'label' => 'خودرو',
        'searchPlaceholder' => 'جستجوی خودرو، صاحب یا شماره...',
        'meta' => fn ($i) => [['user', 'صاحب: ' . $i->owner_name], ['phone', $i->owner_phone, true]],
        'links' => fn ($i) => [],
    ])
@endsection
