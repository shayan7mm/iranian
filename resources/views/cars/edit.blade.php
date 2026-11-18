@extends('layouts.panel')

@section('title', 'ویرایش خودرو')
@section('heading', 'ویرایش خودرو')
@section('subheading', $car->name)
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('cars.index') }}">خودروها</a> / <span>ویرایش خودرو</span>
@endsection

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('cars.update', $car) }}" class="card-body">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="field full">
                    <label for="name">نام خودرو <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $car->name) }}" placeholder="مثال: پراید سفید" required>
                    @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="owner_name">نام صاحب خودرو <span class="req">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name', $car->owner_name) }}" placeholder="نام و نام خانوادگی" required>
                    @error('owner_name') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="owner_phone">شماره تماس صاحب خودرو <span class="req">*</span></label>
                    <input type="text" id="owner_phone" name="owner_phone" value="{{ old('owner_phone', $car->owner_phone) }}" placeholder="09123456789" dir="ltr" required>
                    @error('owner_phone') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="description">توضیحات</label>
                    <textarea id="description" name="description" rows="3">{{ old('description', $car->description) }}</textarea>
                    @error('description') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <span class="label">وضعیت خودرو</span>
                    @php($st = old('status', $car->status))
                    <div class="segmented">
                        <label class="income"><input type="radio" id="status_active" name="status" value="active" @checked($st === 'active')> <x-icon name="check" /> فعال</label>
                        <label class="expense"><input type="radio" id="status_archived" name="status" value="archived" @checked($st === 'archived')> <x-icon name="archive" /> آرشیو</label>
                    </div>
                    @error('status') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ route('cars.index') }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره تغییرات</button>
            </div>
        </form>
    </div>
@endsection
