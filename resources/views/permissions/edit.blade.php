@extends('layouts.panel')

@section('title', 'تنظیم دسترسی‌ها')
@section('heading', 'تنظیم دسترسی‌های ' . $user->name)
@section('subheading', 'نقش: ' . ($user->isMaster() ? 'مدیر ارشد' : 'حسابدار'))
@section('crumbs')
    <a href="{{ route('dashboard') }}">داشبورد</a> / <a href="{{ route('master.users') }}">کاربران</a> / <a href="{{ route('permissions.index', $user) }}">دسترسی‌ها</a> / <span>ویرایش</span>
@endsection

@push('head')
<style>
    .perm-row { border-top: 1px solid var(--line-soft); padding: 16px 20px; }
    .perm-row:first-child { border-top: none; }
    .perm-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; }
    .perm-title { font-weight: 800; font-size: 15px; }
    .switch { position: relative; width: 48px; height: 26px; border-radius: 99px; background: var(--ink-300); cursor: pointer; transition: background .2s; flex-shrink: 0; border: none; }
    .switch::after { content: ""; position: absolute; top: 3px; right: 3px; width: 20px; height: 20px; border-radius: 50%; background: #fff; transition: transform .2s; box-shadow: var(--shadow-sm); }
    .switch.active { background: var(--brand-600); }
    .switch.active::after { transform: translateX(-22px); }
    .items-box { margin-top: 12px; padding: 12px; background: #F7F9FB; border-radius: 12px; }
    .items-grid { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
    .items-grid label { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #fff; border: 1px solid var(--line); border-radius: 9px; font-size: 13px; cursor: pointer; }
    .items-grid label:has(input:checked) { border-color: var(--brand-500); background: var(--brand-50); color: var(--brand-800); }
    .items-grid input { accent-color: var(--brand-600); }
</style>
@endpush

@section('content')
    <form method="POST" action="{{ route('permissions.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-head">
                <h2><x-icon name="key" /> ماژول‌ها</h2>
                <label class="check"><input type="checkbox" id="select_all" onchange="toggleAll(this)"> انتخاب همه ماژول‌ها</label>
            </div>

            @foreach ($modules as $moduleKey => $moduleName)
                @php
                    $permission = $permissions->where('module', $moduleKey)->first();
                    $access = $permission ? $permission->access : false;
                    $itemIds = $permission ? $permission->item_ids : [];

                    $moduleItems = $items[$moduleKey] ?? collect();
                @endphp
                <div class="perm-row">
                    <div class="perm-head">
                        <div>
                            <div class="perm-title">{{ $moduleName }}</div>
                            @if ($access && $itemIds === null)
                                <span class="badge badge-success">دسترسی کامل به همه</span>
                            @elseif ($access && is_array($itemIds) && count($itemIds) > 0)
                                <span class="badge badge-warn">دسترسی به {{ count($itemIds) }} آیتم</span>
                            @else
                                <span class="badge badge-danger">بدون دسترسی</span>
                            @endif
                        </div>
                        <div class="switch toggle-switch {{ $access ? 'active' : '' }}" role="switch" aria-checked="{{ $access ? 'true' : 'false' }}" tabindex="0" onclick="toggleSwitch(this, 'module_{{ $moduleKey }}')">
                            <input type="hidden" name="permissions[{{ $moduleKey }}][module]" value="{{ $moduleKey }}">
                            <input type="hidden" name="permissions[{{ $moduleKey }}][access]" id="module_{{ $moduleKey }}" value="{{ $access ? 1 : 0 }}">
                        </div>
                    </div>

                    <div class="items-box" style="{{ $access ? '' : 'display:none;' }}" id="items_{{ $moduleKey }}">
                        <label class="check all-items">
                            <input type="checkbox" id="all_items_{{ $moduleKey }}" onchange="toggleAllItems('{{ $moduleKey }}', this)" {{ $itemIds === null ? 'checked' : '' }}>
                            دسترسی به همه آیتم‌ها
                        </label>
                        <div class="items-grid" id="items_grid_{{ $moduleKey }}">
                            @forelse ($moduleItems as $item)
                                <label>
                                    <input type="checkbox" name="permissions[{{ $moduleKey }}][item_ids][]" value="{{ $item->id }}"
                                        {{ in_array($item->id, (array) ($itemIds ?? [])) ? 'checked' : '' }}
                                        {{ $itemIds === null ? 'disabled' : '' }}>
                                    {{ $item->name }}
                                </label>
                            @empty
                                <span class="hint">{{ $moduleKey === 'expenses' ? 'این بخش آیتم جداگانه ندارد؛ هر حسابدار فقط ثبت‌های خودش را می‌بیند.' : 'هنوز آیتمی در این بخش ثبت نشده است.' }}</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="card-foot">
                <a href="{{ route('permissions.index', $user) }}" class="btn btn-ghost">انصراف</a>
                <button type="submit" class="btn btn-primary"><x-icon name="check" /> ذخیره دسترسی‌ها</button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
function setModule(toggle, on) {
    var input = toggle.querySelector('input[id^="module_"]');
    var box = document.getElementById('items_' + input.id.replace('module_', ''));
    toggle.classList.toggle('active', on);
    toggle.setAttribute('aria-checked', on ? 'true' : 'false');
    input.value = on ? 1 : 0;
    if (box) box.style.display = on ? '' : 'none';
}
function toggleSwitch(element) {
    setModule(element, !element.classList.contains('active'));
}
function toggleAllItems(moduleKey, checkbox) {
    document.querySelectorAll('#items_grid_' + moduleKey + ' input[type="checkbox"]').forEach(function (cb) {
        if (checkbox.checked) cb.checked = false;
        cb.disabled = checkbox.checked;
    });
}
function toggleAll(checkbox) {
    document.querySelectorAll('.toggle-switch').forEach(function (t) { setModule(t, checkbox.checked); });
}
document.querySelectorAll('.toggle-switch').forEach(function (t) {
    t.addEventListener('keydown', function (e) {
        if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); toggleSwitch(t); }
    });
});
</script>
@endpush
