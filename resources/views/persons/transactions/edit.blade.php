@extends('layouts.panel')

@section('title', 'ویرایش تراکنش')
@section('heading', 'ویرایش تراکنش')
@section('subheading', 'شخص' . ': ' . $person->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('persons.index') }}">اشخاص</a> / <a href="{{ route('persons.transactions.index', $person) }}">{{ $person->name }}</a> / <span>ویرایش تراکنش</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('persons.transactions.update', [$person, $transaction]) }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @method('PUT')
            @include('partials.ledger.transaction-form', ['transaction' => $transaction])
            <div class="form-actions">
                <a href="{{ route('persons.transactions.index', $person) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
