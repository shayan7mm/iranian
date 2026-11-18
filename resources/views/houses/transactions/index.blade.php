@extends('layouts.panel')

@section('title', 'کارت مالی')
@section('heading', 'کارت مالی: ' . $house->name)
@section('subheading', $house->owner_name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <span>کارت مالی</span>
@endsection

@section('actions')
    <a href="{{ route('houses.transactions.create', $house) }}" class="btn btn-primary"><x-icon name="plus" /> تراکنش جدید</a>
@endsection

@section('content')
    @include('partials.ledger.transactions', [
        'prefix' => 'houses',
        'owner' => $house,
        'ownerLabel' => 'ملک',
    ])
@endsection
