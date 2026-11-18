@extends('layouts.panel')

@section('title', 'ویرایش اجاره')
@section('heading', 'ویرایش اجاره')
@section('subheading', $house->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <a href="{{ route('houses.rents.index', $house) }}">اجاره‌ها</a> / <span>ویرایش اجاره</span>
@endsection

@section('content')
    <div class="alert alert-info"><x-icon name="info" /> <div>با ذخیره، اقساط پرداخت‌نشده بر اساس مبلغ و تاریخ جدید از نو ساخته می‌شوند. اقساط پرداخت‌شده و تراکنش‌هایشان حفظ می‌شوند.</div></div>
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('houses.rents.update', [$house, $rent]) }}" class="card-body">
            @csrf
            @method('PUT')
            @include('partials.ledger.plan-form', ['plan' => $rent, 'isLoan' => false])
            <div class="form-actions">
                <a href="{{ route('houses.rents.index', $house) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
