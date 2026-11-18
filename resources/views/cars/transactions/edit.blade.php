@extends('layouts.panel')

@section('title', 'ویرایش تراکنش')
@section('heading', 'ویرایش تراکنش')
@section('subheading', 'خودرو' . ': ' . $car->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('cars.index') }}">خودروها</a> / <a href="{{ route('cars.transactions.index', $car) }}">{{ $car->name }}</a> / <span>ویرایش تراکنش</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('cars.transactions.update', [$car, $transaction]) }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @method('PUT')
            @include('partials.ledger.transaction-form', ['transaction' => $transaction, 'dateField' => view('cars.transactions._legacy-date-field', ['transaction' => $transaction])->render()])
            <div class="form-actions">
                <a href="{{ route('cars.transactions.index', $car) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
