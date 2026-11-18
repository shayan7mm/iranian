@extends('layouts.panel')

@section('title', 'تراکنش جدید')
@section('heading', 'ثبت تراکنش جدید')
@section('subheading', 'خودرو' . ': ' . $car->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('cars.index') }}">خودروها</a> / <a href="{{ route('cars.transactions.index', $car) }}">{{ $car->name }}</a> / <span>تراکنش جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('cars.transactions.store', $car) }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @include('partials.ledger.transaction-form', ['transaction' => null])
            <div class="form-actions">
                <a href="{{ route('cars.transactions.index', $car) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت تراکنش</button>
            </div>
        </form>
    </div>
@endsection
