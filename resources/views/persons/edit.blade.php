@extends('layouts.panel')

@section('title', 'ویرایش شخص')
@section('heading', 'ویرایش شخص')
@section('subheading', $person->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('persons.index') }}">اشخاص</a> / <span>ویرایش شخص</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('persons.update', $person) }}" class="card-body">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام شخص <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $person->name) }}" placeholder="نام و نام خانوادگی" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="description">توضیحات</label>
                    <textarea id="description" name="description" rows="3">{{ old('description', $person->description) }}</textarea>
                    @error('description') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <span class="label">وضعیت شخص</span>
                    @php($st = old('status', $person->status))
                    <div class="segmented">
                        <label class="income"><input type="radio" id="status_active" name="status" value="active" @checked($st === 'active')> <x-icon name="check" /> فعال</label>
                        <label class="expense"><input type="radio" id="status_archived" name="status" value="archived" @checked($st === 'archived')> <x-icon name="archive" /> آرشیو</label>
                    </div>
                    @error('status') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('persons.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
