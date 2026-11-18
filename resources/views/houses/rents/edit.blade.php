@extends('layouts.panel')

@section('title', 'ویرایش اجاره')
@section('heading', 'ویرایش اجاره')
@section('subheading', $house->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('houses.index') }}">املاک و اجاره</a> / <a href="{{ route('houses.rents.index', $house) }}">اجاره‌ها</a> / <span>ویرایش اجاره</span>
@endsection

@section('content')
    <div class="alert alert-warn"><x-icon name="alert" /> <div>توجه: با ذخیره این فرم، همه اقساط از نو ساخته می‌شوند و وضعیت «پرداخت شده» اقساط قبلی پاک می‌شود.</div></div>
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
