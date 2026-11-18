{{--
    فهرست قراردادهای اقساطی (اجاره‌ها / وام‌ها) به‌همراه جدول اقساط
    پارامترها: $plans, $route ('houses.rents' | 'organizations.loans'), $owner, $isLoan (bool), $canCancel (bool), $emptyText
--}}
@forelse ($plans as $plan)
    @php
        $count = $plan->installments->count();
        $paid = $plan->getPaidCount();
        $pct = $count ? round($paid / $count * 100) : 0;
        $isIn = $isLoan ? $plan->isLoanGiven() : $plan->isRentOut();
        $typeText = $isLoan
            ? ($plan->isLoanGiven() ? 'وام داده شده' : 'وام گرفته شده')
            : ($plan->isRentOut() ? 'اجاره داده شده' : 'اجاره گرفته شده');
        $statusText = $plan->isActive() ? 'فعال' : ($plan->isCompleted() ? 'تکمیل شده' : 'لغو شده');
        $statusClass = $plan->isActive() ? 'badge-active' : ($plan->isCompleted() ? 'badge-info' : 'badge-muted');
    @endphp
    <div class="card">
        <div class="card-head">
            <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                <span class="badge {{ $isIn ? 'badge-income' : 'badge-expense' }}">
                    <x-icon :name="$isIn ? 'arrow-down' : 'arrow-up'" class="icon icon-sm" /> {{ $typeText }}
                </span>
                <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
            </div>
            <div class="actions">
                <a href="{{ route($route . '.edit', [$owner, $plan]) }}" class="btn btn-soft btn-sm"><x-icon name="edit" /> ویرایش</a>
                <form action="{{ route($route . '.destroy', [$owner, $plan]) }}" method="POST" class="inline-form" data-confirm="آیا از حذف این {{ $isLoan ? 'وام' : 'اجاره' }} مطمئن هستید؟">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><x-icon name="trash" /> حذف</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="stats" style="margin-bottom:16px">
                @if ($isLoan)
                    <div class="stat">
                        <div class="stat-icon"><x-icon name="cash" /></div>
                        <div><div class="stat-label">مبلغ کل وام</div><div class="stat-value">{{ number_format($plan->total_amount) }}<small>تومان</small></div>
                        <div class="stat-meta">قسط ماهانه: {{ number_format($plan->monthly_amount) }} تومان</div></div>
                    </div>
                @else
                    <div class="stat">
                        <div class="stat-icon"><x-icon name="cash" /></div>
                        <div><div class="stat-label">اجاره ماهانه</div><div class="stat-value">{{ number_format($plan->monthly_amount) }}<small>تومان</small></div></div>
                    </div>
                @endif
                <div class="stat">
                    <div class="stat-icon"><x-icon name="calendar" /></div>
                    <div><div class="stat-label">مدت قرارداد</div><div class="stat-value" style="font-size:15px"><span class="ltr num">{{ $plan->start_date }}</span> تا <span class="ltr num">{{ $plan->end_date }}</span></div>
                    <div class="stat-meta">{{ $plan->total_months }} ماه</div></div>
                </div>
                <div class="stat income">
                    <div class="stat-icon"><x-icon name="check" /></div>
                    <div style="flex:1"><div class="stat-label">اقساط پرداخت‌شده</div><div class="stat-value">{{ $paid }} <small>از {{ $count }}</small></div>
                    <div class="progress" style="margin-top:6px"><span style="width: {{ $pct }}%"></span></div></div>
                </div>
                <div class="stat gold">
                    <div class="stat-icon"><x-icon name="coins" /></div>
                    <div><div class="stat-label">مبلغ پرداختی</div><div class="stat-value">{{ number_format($plan->getTotalPaidAmount()) }}<small>تومان</small></div>
                    <div class="stat-meta">پرداخت‌نشده: {{ $plan->getUnpaidCount() }} قسط</div></div>
                </div>
            </div>

            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr><th>قسط</th><th>سررسید</th><th>مبلغ (تومان)</th><th>وضعیت</th><th>عملیات</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($plan->installments as $installment)
                            <tr>
                                <td class="num">{{ $installment->installment_number }}</td>
                                <td class="num"><span class="ltr">{{ $installment->due_date }}</span></td>
                                <td class="num" style="font-weight:700">{{ number_format($installment->amount) }}</td>
                                <td>
                                    @if ($installment->is_paid)
                                        <span class="badge badge-paid">پرداخت شده</span>
                                        <span class="cell-sub ltr num">{{ $installment->paid_date }}</span>
                                    @else
                                        <span class="badge badge-pending">پرداخت نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($installment->is_paid)
                                        @if ($canCancel)
                                            <form action="{{ route($route . '.cancel-installment', [$owner, $plan, $installment]) }}" method="POST" class="inline-form" data-confirm="پرداخت این قسط لغو شود؟">
                                                @csrf
                                                <button type="submit" class="btn btn-warn btn-sm"><x-icon name="restore" /> لغو</button>
                                            </form>
                                        @else
                                            <span class="muted">—</span>
                                        @endif
                                    @else
                                        <form action="{{ route($route . '.pay-installment', [$owner, $plan, $installment]) }}" method="POST" class="inline-form">
                                            @csrf
                                            <input type="hidden" name="paid_date" value="{{ verta()->format('Y/m/d') }}">
                                            <button type="submit" class="btn btn-primary btn-sm"><x-icon name="check" /> ثبت پرداخت</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@empty
    <div class="card">
        <div class="empty">
            <div class="empty-icon"><x-icon :name="$isLoan ? 'percent' : 'key'" /></div>
            <h3>{{ $emptyText }}</h3>
            <a href="{{ route($route . '.create', $owner) }}" class="btn btn-primary"><x-icon name="plus" /> ثبت {{ $isLoan ? 'وام' : 'اجاره' }} جدید</a>
        </div>
    </div>
@endforelse
