@extends('layouts.panel')

@section('title', 'تراکنش جدید')
@section('heading', 'ثبت تراکنش جدید')
@section('subheading', 'شخص' . ': ' . $person->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('persons.index') }}">اشخاص</a> / <a href="{{ route('persons.transactions.index', $person) }}">{{ $person->name }}</a> / <span>تراکنش جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('persons.transactions.store', $person) }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @include('partials.ledger.transaction-form', ['transaction' => null])
            <div class="form-actions">
                <a href="{{ route('persons.transactions.index', $person) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت تراکنش</button>
            </div>
        </form>
    </div>
@endsection
