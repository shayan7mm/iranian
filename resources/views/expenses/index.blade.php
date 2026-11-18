@extends('layouts.panel')

@section('title', 'درآمد و هزینه')
@section('heading', 'درآمدها و هزینه‌های جانبی')
@section('subheading', 'ثبت و پیگیری درآمدها و هزینه‌های عمومی')
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <span>درآمد و هزینه</span>
@endsection

@section('actions')
    <a href="{{ route('expenses.create') }}" class="btn btn-primary"><x-icon name="plus" /> ثبت جدید</a>
@endsection

@section('content')
    <div class="stats">
        <div class="stat income">
            <div class="stat-icon"><x-icon name="arrow-down" /></div>
            <div><div class="stat-label">جمع کل درآمدها</div><div class="stat-value">{{ number_format($totalIncome) }}<small>تومان</small></div></div>
        </div>
        <div class="stat expense">
            <div class="stat-icon"><x-icon name="arrow-up" /></div>
            <div><div class="stat-label">جمع کل هزینه‌ها</div><div class="stat-value">{{ number_format($totalExpense) }}<small>تومان</small></div></div>
        </div>
        <div @class(['stat', 'gold', 'gain' => $balance >= 0, 'loss' => $balance < 0])>
            <div class="stat-icon"><x-icon name="wallet" /></div>
            <div><div class="stat-label">موجودی</div><div class="stat-value">{{ number_format($balance) }}<small>تومان</small></div></div>
        </div>
        <div class="stat">
            <div class="stat-icon"><x-icon name="receipt" /></div>
            <div><div class="stat-label">تعداد کل</div><div class="stat-value">{{ $expenses->total() }}</div></div>
        </div>
    </div>

    <form method="GET" action="{{ route('expenses.index') }}" class="toolbar">
        <div class="search">
            <x-icon name="search" />
            <input type="text" name="search" placeholder="جستجو در عنوان، مبلغ، توضیحات..." value="{{ request('search') }}">
        </div>
        <select name="type">
            <option value="">همه</option>
            <option value="income" @selected(request('type') == 'income')>درآمد</option>
            <option value="expense" @selected(request('type') == 'expense')>هزینه</option>
        </select>
        <button type="submit" class="btn btn-primary"><x-icon name="filter" /> اعمال</button>
        @if (request('search') || request('type'))
            <a href="{{ route('expenses.index') }}" class="btn btn-ghost">حذف فیلتر</a>
        @endif
    </form>

    <div class="card">
        <div class="card-head">
            <h2><x-icon name="receipt" /> دفتر درآمد و هزینه</h2>
            <span class="badge badge-brand">{{ $expenses->total() }} مورد</span>
        </div>
        @if ($expenses->count())
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr><th>عنوان</th><th>نوع</th><th>تاریخ</th><th>مبلغ (تومان)</th><th>از / به</th><th>فیش</th><th>عملیات</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            @php
                                try {
                                    $date = \Hekmatinasser\Verta\Verta::parseFormat('Y/m/d', $expense->transaction_date)->format('%d %B %Y');
                                } catch (\Exception $e) {
                                    $date = $expense->transaction_date;
                                }
                            @endphp
                            <tr>
                                <td>
                                    <div class="cell-title">{{ $expense->title }}</div>
                                    @if ($expense->description)
                                        <div class="cell-sub" style="max-width:260px;white-space:pre-line">{{ $expense->description }}</div>
                                    @endif
                                </td>
                                <td><span class="badge {{ $expense->isIncome() ? 'badge-income' : 'badge-expense' }}">{{ $expense->isIncome() ? 'درآمد' : 'هزینه' }}</span></td>
                                <td class="num">{{ $date }}</td>
                                <td class="num {{ $expense->isIncome() ? 'amount-income' : 'amount-expense' }}">{{ number_format($expense->amount) }}</td>
                                <td class="small">
                                    @if ($expense->from_account || $expense->to_account)
                                        <div>از: <span class="ltr">{{ $expense->from_account ?? '-' }}</span></div>
                                        <div>به: <span class="ltr">{{ $expense->to_account ?? '-' }}</span></div>
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($expense->receipt_image)
                                        <a href="{{ asset($expense->receipt_image) }}" target="_blank" rel="noopener"><img src="{{ asset($expense->receipt_image) }}" alt="فیش" class="receipt-thumb" style="width:44px;height:44px"></a>
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-soft btn-sm"><x-icon name="edit" /> ویرایش</a>
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline-form" data-confirm="آیا از حذف این مورد مطمئن هستید؟">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><x-icon name="trash" /></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty">
                <div class="empty-icon"><x-icon name="receipt" /></div>
                <h3>هیچ آیتمی ثبت نشده است</h3>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary"><x-icon name="plus" /> ثبت اولین آیتم</a>
            </div>
        @endif
    </div>

    {{ $expenses->appends(request()->query())->links('partials.pagination') }}
@endsection
