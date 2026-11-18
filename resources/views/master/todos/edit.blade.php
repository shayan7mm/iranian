@extends('layouts.panel')

@section('title', 'ویرایش کار')
@section('heading', 'ویرایش کار')
@section('subheading', $todo->title)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('master.todos.index') }}">کارهای روزانه</a> / <span>ویرایش</span>
@endsection

@section('content')
    <div class="card" style="max-width:760px">
        <form method="POST" action="{{ route('master.todos.update', $todo) }}" class="card-body">
            @csrf
            @method('PUT')
            @include('master.todos._form', ['todo' => $todo])
            <div class="form-actions">
                <a href="{{ route('master.todos.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
