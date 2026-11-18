@extends('layouts.panel')

@section('title', 'اجاره‌ها')
@section('heading', 'قراردادهای اجاره: ' . $house->name)
@section('subheading', 'اقساط ماهانه اجاره و وضعیت پرداخت')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <span>اجاره‌ها</span>
@endsection

@section('actions')
    <a href="{{ route('houses.transactions.index', $house) }}" class="btn btn-outline"><x-icon name="ledger" /> کارت مالی</a>
    <a href="{{ route('houses.rents.create', $house) }}" class="btn btn-primary"><x-icon name="plus" /> اجاره جدید</a>
@endsection

@section('content')
    @include('partials.ledger.installment-plans', [
        'plans' => $rents,
        'route' => 'houses.rents',
        'owner' => $house,
        'isLoan' => false,
        'canCancel' => false,
        'emptyText' => 'هیچ اجاره‌ای برای این ملک ثبت نشده است',
    ])

    {{ $rents->links('partials.pagination') }}
@endsection
