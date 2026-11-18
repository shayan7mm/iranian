@extends('layouts.panel')

@section('title', 'تراکنش جدید')
@section('heading', 'ثبت تراکنش جدید')
@section('subheading', 'ارگان' . ': ' . $organization->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('organizations.index') }}">ارگان‌ها و وام‌ها</a> / <a href="{{ route('organizations.transactions.index', $organization) }}">{{ $organization->name }}</a> / <span>تراکنش جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('organizations.transactions.store', $organization) }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @include('partials.ledger.transaction-form', ['transaction' => null])
            <div class="form-actions">
                <a href="{{ route('organizations.transactions.index', $organization) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت تراکنش</button>
            </div>
        </form>
    </div>
@endsection
