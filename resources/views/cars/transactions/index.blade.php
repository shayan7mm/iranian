@extends('layouts.panel')

@section('title', 'کارت مالی')
@section('heading', 'کارت مالی: ' . $car->name)
@section('subheading', $car->owner_name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('cars.index') }}">خودروها</a> / <span>کارت مالی</span>
@endsection

@section('actions')
    <a href="{{ route('cars.transactions.create', $car) }}" class="btn btn-primary"><x-icon name="plus" /> تراکنش جدید</a>
@endsection

@section('content')
    @include('partials.ledger.transactions', [
        'prefix' => 'cars',
        'owner' => $car,
        'ownerLabel' => 'خودرو',
    ])
@endsection
