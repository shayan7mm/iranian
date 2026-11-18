@extends('layouts.panel')

@section('title', 'داشبورد مدیریت')
@section('heading', 'داشبورد مدیریت')
@section('subheading', 'نمای کلی سیستم حسابداری ایرانیان و حسابداران')

@section('actions')
    <a href="{{ route('master.users.create') }}" class="btn btn-primary"><x-icon name="plus" /> حسابدار جدید</a>
@endsection

@section('content')
    <div class="stats">
        <div class="stat">
            <div class="stat-icon"><x-icon name="users" /></div>
            <div>
                <div class="stat-label">کل حسابداران</div>
                <div class="stat-value">{{ $totalAccountants }}</div>
            </div>
        </div>
        <div class="stat income">
            <div class="stat-icon"><x-icon name="check" /></div>
            <div>
                <div class="stat-label">حسابداران فعال</div>
                <div class="stat-value">{{ $activeAccountants }}</div>
            </div>
        </div>
        <div class="stat expense">
            <div class="stat-icon"><x-icon name="x" /></div>
            <div>
                <div class="stat-label">حسابداران غیرفعال</div>
                <div class="stat-value">{{ $inactiveAccountants }}</div>
            </div>
        </div>
        <a href="{{ route('master.users') }}" class="stat gold" style="color:inherit">
            <div class="stat-icon"><x-icon name="shield" /></div>
            <div>
                <div class="stat-label">مدیریت کاربران</div>
                <div class="stat-value" style="font-size:15px">مشاهده همه ←</div>
            </div>
        </a>
    </div>

    <div class="card" style="margin-bottom:18px">
        <div class="card-head"><h2><x-icon name="ledger" /> دفاتر حسابداری</h2></div>
        <div class="card-body">
            <div class="shortcuts">
                <a href="{{ route('persons.index') }}" class="shortcut">
                    <span class="s-icon"><x-icon name="users" /></span>
                    <span class="s-title">اشخاص</span>
                    <span class="s-sub">حساب‌های اشخاص</span>
                </a>
                <a href="{{ route('organizations.index') }}" class="shortcut">
                    <span class="s-icon"><x-icon name="bank" /></span>
                    <span class="s-title">ارگان‌ها و وام‌ها</span>
                    <span class="s-sub">تراکنش و اقساط وام</span>
                </a>
                <a href="{{ route('houses.index') }}" class="shortcut">
                    <span class="s-icon"><x-icon name="home" /></span>
                    <span class="s-title">املاک و اجاره</span>
                    <span class="s-sub">تراکنش و اقساط اجاره</span>
                </a>
                <a href="{{ route('cars.index') }}" class="shortcut">
                    <span class="s-icon"><x-icon name="car" /></span>
                    <span class="s-title">خودروها</span>
                    <span class="s-sub">کارت مالی خودروها</span>
                </a>
                <a href="{{ route('expenses.index') }}" class="shortcut">
                    <span class="s-icon"><x-icon name="receipt" /></span>
                    <span class="s-title">درآمد و هزینه</span>
                    <span class="s-sub">هزینه‌های جانبی</span>
                </a>
                <a href="{{ route('master.users') }}" class="shortcut gold">
                    <span class="s-icon"><x-icon name="shield" /></span>
                    <span class="s-title">کاربران</span>
                    <span class="s-sub">حسابداران و دسترسی‌ها</span>
                </a>
                <a href="{{ route('master.todos.index') }}" class="shortcut gold">
                    <span class="s-icon"><x-icon name="checklist" /></span>
                    <span class="s-title">کارهای روزانه</span>
                    <span class="s-sub">یادداشت و پیگیری</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2><x-icon name="users" /> آخرین حسابداران ثبت‌شده</h2>
            <span class="badge badge-brand">{{ $recentUsers->count() }} نفر</span>
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
                    @forelse ($recentUsers as $key => $user)
                        <tr>
                            <td class="num">{{ $key + 1 }}</td>
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
                                    <form action="{{ route('master.users.destroy', $user) }}" method="POST" class="inline-form" data-confirm="آیا از حذف این کاربر مطمئن هستید؟">
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
        @if ($recentUsers->count() > 0)
            <div class="card-foot"><a href="{{ route('master.users') }}" class="btn btn-ghost btn-sm">مشاهده تمام حسابداران ←</a></div>
        @endif
    </div>
@endsection
