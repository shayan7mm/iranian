@extends('layouts.panel')

@section('title', 'ویرایش تراکنش')
@section('heading', 'ویرایش تراکنش')
@section('subheading', 'ملک' . ': ' . $house->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <a href="{{ route('houses.transactions.index', $house) }}">{{ $house->name }}</a> / <span>ویرایش تراکنش</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('houses.transactions.update', [$house, $transaction]) }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @method('PUT')
            @include('partials.ledger.transaction-form', ['transaction' => $transaction])
            <div class="form-actions">
                <a href="{{ route('houses.transactions.index', $house) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
