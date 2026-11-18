@extends('layouts.panel')

@section('title', 'املاک و اجاره')
@section('heading', 'املاک و اجاره')
@section('subheading', 'کارت مالی املاک و قراردادهای اجاره')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <span>املاک و اجاره</span>
@endsection

@section('actions')
    <a href="{{ route('houses.create') }}" class="btn btn-primary"><x-icon name="plus" /> ملک جدید</a>
@endsection

@section('content')
    @include('partials.ledger.accounts', [
        'items' => $houses,
        'prefix' => 'houses',
        'icon' => 'home',
        'label' => 'ملک',
        'searchPlaceholder' => 'جستجوی ملک، صاحب یا آدرس...',
        'meta' => fn ($i) => [['user', 'صاحب: ' . $i->owner_name], ['home', $i->address]],
        'links' => fn ($i) => [[route('houses.rents.index', $i), 'key', 'اجاره‌ها']],
    ])
@endsection
