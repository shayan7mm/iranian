@extends('layouts.panel')

@section('title', 'تراکنش جدید')
@section('heading', 'ثبت تراکنش جدید')
@section('subheading', 'ملک' . ': ' . $house->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <a href="{{ route('houses.transactions.index', $house) }}">{{ $house->name }}</a> / <span>تراکنش جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('houses.transactions.store', $house) }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @include('partials.ledger.transaction-form', ['transaction' => null])
            <div class="form-actions">
                <a href="{{ route('houses.transactions.index', $house) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت تراکنش</button>
            </div>
        </form>
    </div>
@endsection
