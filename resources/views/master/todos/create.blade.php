@extends('layouts.panel')

@section('title', 'کار جدید')
@section('heading', 'ثبت کار جدید')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('master.todos.index') }}">کارهای روزانه</a> / <span>کار جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:760px">
        <form method="POST" action="{{ route('master.todos.store') }}" class="card-body">
            @csrf
            @include('master.todos._form', ['todo' => null])
            <div class="form-actions">
                <a href="{{ route('master.todos.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت کار</button>
            </div>
        </form>
    </div>
@endsection
