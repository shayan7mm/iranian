{{--
    کارت مالی (لیست تراکنش‌ها) — مشترک بین اشخاص، ارگان‌ها، املاک و خودروها
    پارامترها: $prefix (cars|houses|persons|organizations), $owner, $ownerLabel,
               $transactions, $totalIncome, $totalExpense, $profit
--}}
<div class="stats">
    <div class="stat income">
        <div class="stat-icon"><x-icon name="arrow-down" /></div>
        <div><div class="stat-label">جمع ورودی‌ها</div><div class="stat-value">{{ number_format($totalIncome) }}<small>تومان</small></div></div>
    </div>
    <div class="stat expense">
        <div class="stat-icon"><x-icon name="arrow-up" /></div>
        <div><div class="stat-label">جمع خروجی‌ها</div><div class="stat-value">{{ number_format($totalExpense) }}<small>تومان</small></div></div>
    </div>
    <div @class(['stat', 'gold', 'gain' => $profit >= 0, 'loss' => $profit < 0])>
        <div class="stat-icon"><x-icon name="coins" /></div>
        <div><div class="stat-label">سود خالص (مانده)</div><div class="stat-value">{{ number_format($profit) }}<small>تومان</small></div></div>
    </div>
    <div class="stat">
        <div class="stat-icon"><x-icon name="ledger" /></div>
        <div><div class="stat-label">تعداد تراکنش‌ها</div><div class="stat-value">{{ $transactions->total() }}</div></div>
    </div>
</div>

<form method="GET" action="{{ route($prefix . '.transactions.index', $owner) }}" class="toolbar">
    <div class="search">
        <x-icon name="search" />
        <input type="text" name="search" placeholder="جستجو در تراکنش‌ها..." value="{{ request('search') }}">
    </div>
    <select name="type">
        <option value="">همه تراکنش‌ها</option>
        <option value="income" @selected(request('type') == 'income')>ورودی</option>
        <option value="expense" @selected(request('type') == 'expense')>خروجی</option>
    </select>
    <button type="submit" class="btn btn-primary"><x-icon name="filter" /> اعمال</button>
    @if (request('search') || request('type'))
        <a href="{{ route($prefix . '.transactions.index', $owner) }}" class="btn btn-ghost">حذف فیلتر</a>
    @endif
</form>

<div class="card">
    <div class="card-head">
        <h2><x-icon name="ledger" /> دفتر تراکنش‌ها</h2>
        <span class="badge badge-brand">{{ $transactions->total() }} مورد</span>
    </div>
    @if ($transactions->count())
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>نوع</th>
                        <th>تاریخ</th>
                        <th>مبلغ (تومان)</th>
                        <th>از / به</th>
                        <th>شرح</th>
                        <th>فیش</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        @php
                            try {
                                $date = \Hekmatinasser\Verta\Verta::parseFormat('Y/m/d', $transaction->transaction_date)->format('%d %B %Y');
                            } catch (\Exception $e) {
                                $date = $transaction->transaction_date;
                            }
                        @endphp
                        <tr>
                            <td>
                                <span class="badge {{ $transaction->isIncome() ? 'badge-income' : 'badge-expense' }}">
                                    <x-icon :name="$transaction->isIncome() ? 'arrow-down' : 'arrow-up'" class="icon icon-sm" />
                                    {{ $transaction->isIncome() ? 'ورودی' : 'خروجی' }}
                                </span>
                            </td>
                            <td class="num">{{ $date }}</td>
                            <td class="num {{ $transaction->isIncome() ? 'amount-income' : 'amount-expense' }}">{{ number_format($transaction->amount) }}</td>
                            <td class="small">
                                @if ($transaction->from_account || $transaction->to_account)
                                    <div>از: <span class="ltr">{{ $transaction->from_account ?? '-' }}</span></div>
                                    <div>به: <span class="ltr">{{ $transaction->to_account ?? '-' }}</span></div>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td class="small" style="max-width:280px;white-space:pre-line">{{ $transaction->description ?: '—' }}</td>
                            <td>
                                @if ($transaction->receipt_image)
                                    <a href="{{ asset($transaction->receipt_image) }}" target="_blank" rel="noopener" title="مشاهده فیش">
                                        <img src="{{ asset($transaction->receipt_image) }}" alt="فیش" class="receipt-thumb" style="width:44px;height:44px">
                                    </a>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route($prefix . '.transactions.edit', [$owner, $transaction]) }}" class="btn btn-soft btn-sm"><x-icon name="edit" /> ویرایش</a>
                                    <form action="{{ route($prefix . '.transactions.destroy', [$owner, $transaction]) }}" method="POST" class="inline-form" data-confirm="آیا از حذف این تراکنش مطمئن هستید؟">
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
            <div class="empty-icon"><x-icon name="ledger" /></div>
            <h3>هیچ تراکنشی برای این {{ $ownerLabel }} ثبت نشده است</h3>
            <a href="{{ route($prefix . '.transactions.create', $owner) }}" class="btn btn-primary"><x-icon name="plus" /> ثبت اولین تراکنش</a>
        </div>
    @endif
</div>

{{ $transactions->appends(request()->query())->links('partials.pagination') }}
