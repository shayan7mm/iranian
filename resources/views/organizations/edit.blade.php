@extends('layouts.panel')

@section('title', 'ویرایش ارگان')
@section('heading', 'ویرایش ارگان')
@section('subheading', $organization->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('organizations.index') }}">ارگان‌ها و وام‌ها</a> / <span>ویرایش ارگان</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('organizations.update', $organization) }}" class="card-body">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام ارگان <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $organization->name) }}" placeholder="مثال: بانک ملی شعبه مرکزی" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="description">توضیحات</label>
                    <textarea id="description" name="description" rows="3">{{ old('description', $organization->description) }}</textarea>
                    @error('description') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <span class="label">وضعیت ارگان</span>
                    @php($st = old('status', $organization->status))
                    <div class="segmented">
                        <label class="income"><input type="radio" id="status_active" name="status" value="active" @checked($st === 'active')> <x-icon name="check" /> فعال</label>
                        <label class="expense"><input type="radio" id="status_archived" name="status" value="archived" @checked($st === 'archived')> <x-icon name="archive" /> آرشیو</label>
                    </div>
                    @error('status') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('organizations.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
