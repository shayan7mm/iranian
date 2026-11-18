@extends('layouts.panel')

@section('title', 'حسابداران')
@section('heading', 'کاربران و حسابداران')
@section('subheading', 'مدیریت حساب‌های حسابداران و سطح دسترسی آن‌ها')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <span>کاربران</span>
@endsection

@section('actions')
    <a href="{{ route('master.users.create') }}" class="btn btn-primary"><x-icon name="plus" /> حسابدار جدید</a>
@endsection

@section('content')
    <div class="stats">
        <div class="stat">
            <div class="stat-icon"><x-icon name="users" /></div>
            <div>
                <div class="stat-label">کل حسابداران</div>
                <div class="stat-value">{{ $users->total() }}</div>
            </div>
        </div>
        <div class="stat income">
            <div class="stat-icon"><x-icon name="check" /></div>
            <div>
                <div class="stat-label">فعال (این صفحه)</div>
                <div class="stat-value">{{ $users->where('is_active', true)->count() }}</div>
            </div>
        </div>
        <div class="stat expense">
            <div class="stat-icon"><x-icon name="x" /></div>
            <div>
                <div class="stat-label">غیرفعال (این صفحه)</div>
                <div class="stat-value">{{ $users->where('is_active', false)->count() }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2><x-icon name="users" /> فهرست حسابداران</h2>
            <span class="badge badge-brand">{{ $users->total() }} نفر</span>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>موبایل</th>
                        <th>وضعیت</th>
                        <th>تاریخ ثبت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                        <tr>
                            <td class="num">{{ $users->firstItem() + $key }}</td>
                            <td class="cell-title">{{ $user->name }}</td>
                            <td><span class="ltr">{{ $user->email }}</span></td>
                            <td><span class="ltr num">{{ $user->phone }}</span></td>
                            <td>
                                <span class="badge {{ $user->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $user->is_active ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td class="num">{{ verta($user->created_at)->format('%d %B %Y') }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('master.users.edit', $user) }}" class="btn btn-soft btn-sm"><x-icon name="edit" /> ویرایش</a>
                                    <a href="{{ route('permissions.index', $user) }}" class="btn btn-warn btn-sm"><x-icon name="key" /> دسترسی</a>
                                    <form action="{{ route('master.users.destroy', $user) }}" method="POST" class="inline-form" data-confirm="آیا از حذف «{{ $user->name }}» مطمئن هستید؟">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><x-icon name="trash" /> حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty">
                                    <div class="empty-icon"><x-icon name="users" /></div>
                                    <h3>هیچ حسابداری ثبت نشده است</h3>
                                    <a href="{{ route('master.users.create') }}" class="btn btn-primary"><x-icon name="plus" /> ثبت اولین حسابدار</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links('partials.pagination') }}
@endsection
