@extends('layouts.panel')

@section('title', 'ثبت درآمد / هزینه')
@section('heading', 'ثبت درآمد / هزینه')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('expenses.index') }}">درآمد و هزینه</a> / <span>ثبت جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @include('partials.ledger.transaction-form', [
                'transaction' => null,
                'withTitle' => true,
                'incomeLabel' => 'درآمد',
                'expenseLabel' => 'هزینه',
            ])
            <div class="form-actions">
                <a href="{{ route('expenses.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت</button>
            </div>
        </form>
    </div>
@endsection
