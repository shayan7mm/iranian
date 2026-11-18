@extends('layouts.panel')

@section('title', 'ویرایش درآمد / هزینه')
@section('heading', 'ویرایش درآمد / هزینه')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('expenses.index') }}">درآمد و هزینه</a> / <span>ویرایش</span>
@endsection

@section('content')
    <div class="card" style="max-width:860px">
        <form method="POST" action="{{ route('expenses.update', $expense) }}" enctype="multipart/form-data" class="card-body">
            @csrf
            @method('PUT')
            @include('partials.ledger.transaction-form', [
                'transaction' => $expense,
                'withTitle' => true,
                'incomeLabel' => 'درآمد',
                'expenseLabel' => 'هزینه',
            ])
            <div class="form-actions">
                <a href="{{ route('expenses.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
