@extends('layouts.panel')

@section('title', 'کارت مالی')
@section('heading', 'کارت مالی: ' . $person->name)
@section('subheading', 'کارت مالی شخص')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('persons.index') }}">اشخاص</a> / <span>کارت مالی</span>
@endsection

@section('actions')
    <a href="{{ route('persons.transactions.create', $person) }}" class="btn btn-primary"><x-icon name="plus" /> تراکنش جدید</a>
@endsection

@section('content')
    @include('partials.ledger.transactions', [
        'prefix' => 'persons',
        'owner' => $person,
        'ownerLabel' => 'شخص',
    ])
@endsection
