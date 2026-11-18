{{--
    فهرست حساب‌ها (اشخاص، ارگان‌ها، املاک، خودروها) به شکل کارت
    پارامترها: $items, $prefix, $icon, $label, $searchPlaceholder,
               $meta (closure: آیتم => آرایه‌ای از [آیکون, متن, ltr?]), $links (closure: آیتم => آرایه‌ای از [route, آیکون, متن])
--}}
<form method="GET" action="{{ route($prefix . '.index') }}" class="toolbar">
    <div class="search">
        <x-icon name="search" />
        <input type="text" name="search" placeholder="{{ $searchPlaceholder }}" value="{{ request('search') }}">
    </div>
    <select name="status">
        <option value="active" @selected(request('status') == 'active')>فعال</option>
        <option value="archived" @selected(request('status') == 'archived')>آرشیو</option>
        <option value="" @selected(! request('status'))>همه</option>
    </select>
    <button type="submit" class="btn btn-primary"><x-icon name="filter" /> اعمال</button>
    @if (request('search') || request('status'))
        <a href="{{ route($prefix . '.index') }}" class="btn btn-ghost">حذف فیلتر</a>
    @endif
</form>

<div class="grid-cards">
    @forelse ($items as $item)
        @php
            $totalIncome = $item->totalIncome();
            $totalExpense = $item->totalExpense();
            $profit = $item->profit();
        @endphp
        <div class="acct">
            <div class="acct-head">
                <div class="acct-avatar"><x-icon :name="$icon" /></div>
                <div style="flex:1;min-width:0">
                    <div class="acct-title">{{ $item->name }}</div>
                    <div class="acct-meta">
                        @foreach ($meta($item) as $m)
                            @if (filled($m[1]))
                                <span><x-icon :name="$m[0]" class="icon icon-sm" /> <span @if (! empty($m[2])) class="ltr" @endif>{{ $m[1] }}</span></span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <span class="badge {{ $item->isActive() ? 'badge-active' : 'badge-archived' }}">{{ $item->isActive() ? 'فعال' : 'آرشیو' }}</span>
            </div>
            <div class="acct-body">
                <div class="acct-figures">
                    <div><div class="k">ورودی</div><div class="v in">{{ number_format($totalIncome) }}</div></div>
                    <div><div class="k">خروجی</div><div class="v out">{{ number_format($totalExpense) }}</div></div>
                    <div><div class="k">مانده / سود</div><div class="v {{ $profit >= 0 ? 'in' : 'out' }}">{{ number_format($profit) }}</div></div>
                </div>
            </div>
            <div class="acct-foot">
                <a href="{{ route($prefix . '.transactions.index', $item) }}" class="btn btn-soft btn-sm"><x-icon name="ledger" /> کارت مالی</a>
                <a href="{{ route($prefix . '.transactions.create', $item) }}" class="btn btn-success btn-sm"><x-icon name="plus" /> تراکنش</a>
                @foreach ($links($item) as $l)
                    <a href="{{ $l[0] }}" class="btn btn-warn btn-sm"><x-icon :name="$l[1]" /> {{ $l[2] }}</a>
                @endforeach
                <span class="spacer"></span>
                @if ($item->isArchived())
                    <form action="{{ route($prefix . '.restore', $item->id) }}" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm" title="بازیابی"><x-icon name="restore" /></button>
                    </form>
                @endif
                <a href="{{ route($prefix . '.edit', $item) }}" class="btn btn-ghost btn-sm" title="ویرایش"><x-icon name="edit" /></a>
                <form action="{{ route($prefix . '.destroy', $item) }}" method="POST" class="inline-form" data-confirm="{{ $item->isActive() ? 'این ' . $label . ' آرشیو شود؟' : 'این ' . $label . ' برای همیشه حذف شود؟' }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-ghost btn-sm" title="{{ $item->isActive() ? 'آرشیو' : 'حذف' }}" style="color:var(--expense)"><x-icon :name="$item->isActive() ? 'archive' : 'trash'" /></button>
                </form>
            </div>
        </div>
    @empty
        <div class="card" style="grid-column:1/-1">
            <div class="empty">
                <div class="empty-icon"><x-icon :name="$icon" /></div>
                <h3>هیچ {{ $label }}ی ثبت نشده است</h3>
                <a href="{{ route($prefix . '.create') }}" class="btn btn-primary"><x-icon name="plus" /> ثبت اولین {{ $label }}</a>
            </div>
        </div>
    @endforelse
</div>

{{ $items->appends(request()->query())->links('partials.pagination') }}
