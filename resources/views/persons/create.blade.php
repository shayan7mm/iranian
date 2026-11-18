@extends('layouts.panel')

@section('title', 'شخص جدید')
@section('heading', 'ثبت شخص جدید')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('persons.index') }}">اشخاص</a> / <span>شخص جدید</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('persons.store') }}" class="card-body">
            @csrf
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام شخص <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="نام و نام خانوادگی" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="description">توضیحات</label>
                    <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('persons.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ثبت شخص</button>
            </div>
        </form>
    </div>
@endsection
