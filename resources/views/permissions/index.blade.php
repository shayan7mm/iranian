@extends('layouts.panel')

@section('title', 'دسترسی‌ها')
@section('heading', 'دسترسی‌های ' . $user->name)
@section('subheading', 'نقش: ' . ($user->isMaster() ? 'مدیر ارشد' : 'حسابدار'))
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('master.users') }}">کاربران</a> / <span>دسترسی‌ها</span>
@endsection

@section('actions')
    <a href="{{ route('permissions.edit', $user) }}" class="btn btn-primary"><x-icon name="edit" /> ویرایش دسترسی‌ها</a>
@endsection

@section('content')
    @if ($permissions->isEmpty())
        <div class="card">
            <div class="empty">
                <div class="empty-icon"><x-icon name="key" /></div>
                <h3>هیچ دسترسی برای این کاربر تعریف نشده است</h3>
                <p>تا زمانی که دسترسی تعریف نشود، این کاربر هیچ بخشی را نمی‌بیند.</p>
                <a href="{{ route('permissions.edit', $user) }}" class="btn btn-primary"><x-icon name="key" /> تنظیم دسترسی‌ها</a>
            </div>
        </div>
    @else
        <div class="grid-cards">
            @foreach ($permissions as $permission)
                @php
                    $moduleName = $modules[$permission->module] ?? $permission->module;
                    $statusText = 'بدون دسترسی';
                    $statusClass = 'badge-danger';
                    if ($permission->access) {
                        if ($permission->item_ids === null) {
                            $statusText = 'دسترسی کامل';
                            $statusClass = 'badge-success';
                        } elseif (is_array($permission->item_ids) && count($permission->item_ids) > 0) {
                            $statusText = 'دسترسی محدود';
                            $statusClass = 'badge-warn';
                        }
                    }
                @endphp
                <div class="acct">
                    <div class="acct-head">
                        <div class="acct-avatar"><x-icon name="key" /></div>
                        <div style="flex:1">
                            <div class="acct-title">{{ $moduleName }}</div>
                            <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                        </div>
                    </div>
                    <div class="acct-body">
                        <div class="actions">
                            @if ($permission->item_ids !== null && is_array($permission->item_ids))
                                @forelse ($permission->item_ids as $itemId)
                                    <span class="badge badge-muted num">#{{ $itemId }}</span>
                                @empty
                                    <span class="badge badge-muted">هیچ آیتمی</span>
                                @endforelse
                            @elseif ($permission->access && $permission->item_ids === null)
                                <span class="badge badge-brand">همه آیتم‌ها</span>
                            @endif
                        </div>
                    </div>
                    <div class="acct-foot">
                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="inline-form" data-confirm="آیا از حذف این دسترسی مطمئن هستید؟">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><x-icon name="trash" /> حذف دسترسی</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
