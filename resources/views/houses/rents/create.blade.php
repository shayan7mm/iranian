@extends('layouts.panel')

@section('title', 'اجاره جدید')
@section('heading', 'ثبت اجاره جدید')
@section('subheading', $house->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <a href="{{ route('houses.rents.index', $house) }}">اجاره‌ها</a> / <span>اجاره جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('houses.rents.store', $house) }}" class="card-body">
            @csrf
            @include('partials.ledger.plan-form', ['plan' => null, 'isLoan' => false])
            <div class="form-actions">
                <a href="{{ route('houses.rents.index', $house) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت اجاره</button>
            </div>
        </form>
    </div>
@endsection
