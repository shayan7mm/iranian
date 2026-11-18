@extends('layouts.panel')

@section('title', 'کارهای روزانه')
@section('heading', 'کارهای روزانه')
@section('subheading', 'یادداشت و پیگیری کارهای مدیر')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <span>کارهای روزانه</span>
@endsection

@section('actions')
    <a href="{{ route('master.todos.create') }}" class="btn btn-primary"><x-icon name="plus" /> کار جدید</a>
@endsection

@push('head')
<style>
    .todo { display: flex; gap: 14px; align-items: flex-start; padding: 16px 20px; border-top: 1px solid var(--line-soft); flex-wrap: wrap; }
    .todo:first-child { border-top: none; }
    .todo-check { width: 26px; height: 26px; border-radius: 8px; border: 2px solid var(--ink-300); display: grid; place-items: center; background: #fff; cursor: pointer; color: transparent; padding: 0; }
    .todo-check:hover { border-color: var(--brand-500); }
    .todo.done .todo-check { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
    .todo-main { flex: 1; min-width: 200px; }
    .todo-title { font-weight: 800; font-size: 14.5px; overflow-wrap: anywhere; }
    .todo.done .todo-title { text-decoration: line-through; color: var(--ink-400); }
    .todo-desc { font-size: 13px; color: var(--ink-500); margin-top: 2px; white-space: pre-line; overflow-wrap: anywhere; }
    .todo-meta { display: flex; gap: 12px; flex-wrap: wrap; font-size: 12px; color: var(--ink-400); margin-top: 6px; }
    .todo-meta span { display: inline-flex; align-items: center; gap: 4px; }
</style>
@endpush

@section('content')
    <div class="stats">
        <div class="stat">
            <div class="stat-icon"><x-icon name="checklist" /></div>
            <div><div class="stat-label">کل کارها</div><div class="stat-value">{{ $totalAll }}</div></div>
        </div>
        <div class="stat income">
            <div class="stat-icon"><x-icon name="check" /></div>
            <div><div class="stat-label">انجام شده</div><div class="stat-value">{{ $totalCompleted }}</div></div>
        </div>
        <div class="stat warn">
            <div class="stat-icon"><x-icon name="clock" /></div>
            <div><div class="stat-label">در انتظار</div><div class="stat-value">{{ $totalPending }}</div></div>
        </div>
    </div>

    <form method="GET" action="{{ route('master.todos.index') }}" class="toolbar">
        <div class="search">
            <x-icon name="search" />
            <input type="text" name="search" placeholder="جستجو در عنوان یا توضیحات..." value="{{ request('search') }}">
        </div>
        <select name="filter">
            <option value="all" @selected(request('filter') == 'all')>همه</option>
            <option value="pending" @selected(request('filter') == 'pending')>در انتظار</option>
            <option value="completed" @selected(request('filter') == 'completed')>انجام شده</option>
        </select>
        <button type="submit" class="btn btn-primary"><x-icon name="filter" /> اعمال</button>
        @if (request('search') || request('filter'))
            <a href="{{ route('master.todos.index') }}" class="btn btn-ghost">حذف فیلتر</a>
        @endif
    </form>

    <div class="card">
        @forelse ($todos as $todo)
            <div @class(['todo', 'done' => $todo->is_completed])>
                <form action="{{ route('master.todos.toggle', $todo) }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="todo-check" title="{{ $todo->is_completed ? 'بازگشت به در انتظار' : 'علامت انجام شد' }}"><x-icon name="check" class="icon icon-sm" /></button>
                </form>
                <div class="todo-main">
                    <div class="todo-title">{{ $todo->title }}</div>
                    @if ($todo->description)
                        <div class="todo-desc">{{ $todo->description }}</div>
                    @endif
                    <div class="todo-meta">
                        <span class="badge {{ $todo->is_completed ? 'badge-completed' : 'badge-pending' }}">{{ $todo->is_completed ? 'انجام شده' : 'در انتظار' }}</span>
                        @if ($todo->due_date)
                            <span><x-icon name="calendar" class="icon icon-sm" /> سررسید: <span class="ltr num">{{ $todo->due_date }}</span></span>
                        @endif
                        @if ($todo->completed_at && $todo->is_completed)
                            <span><x-icon name="check" class="icon icon-sm" /> انجام: {{ verta($todo->completed_at)->format('%d %B %Y') }}</span>
                        @endif
                    </div>
                </div>
                <div class="actions">
                    <form action="{{ route('master.todos.toggle', $todo) }}" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $todo->is_completed ? 'btn-warn' : 'btn-success' }}">
                            {{ $todo->is_completed ? 'بازگشت' : 'انجام شد' }}
                        </button>
                    </form>
                    <a href="{{ route('master.todos.edit', $todo) }}" class="btn btn-soft btn-sm"><x-icon name="edit" /> ویرایش</a>
                    <form action="{{ route('master.todos.destroy', $todo) }}" method="POST" class="inline-form" data-confirm="آیا از حذف این کار مطمئن هستید؟">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><x-icon name="trash" /></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty">
                <div class="empty-icon"><x-icon name="checklist" /></div>
                <h3>هیچ کاری ثبت نشده است</h3>
                <a href="{{ route('master.todos.create') }}" class="btn btn-primary"><x-icon name="plus" /> ثبت اولین کار</a>
            </div>
        @endforelse
    </div>

    {{ $todos->appends(request()->query())->links('partials.pagination') }}
@endsection
