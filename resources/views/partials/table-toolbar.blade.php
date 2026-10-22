{{-- Search box + filter panel for the table next to it (inside [data-table-tools]).
     filters: [['key' => 'stage', 'label_key' => 'col_stage', 'label' => 'قۆناغ', 'kind' => 'bool'(optional)], ...]
     locks:   ['department' => 'Computer Science']  → that filter is fixed and cannot be changed by the user.
     Each <tr> carries data-<key>="value" for every filter key. --}}
@php
    $filters = $filters ?? [];
    $locks = $locks ?? [];
@endphp
<div class="toolbar">
    <div class="search_box">
        @include('partials.icon', ['name' => 'search'])
        <label class="sr_only" for="table_search" data-i18n="search_label">گەڕان</label>
        <input type="search" id="table_search" data-search data-i18n="search_placeholder" placeholder="گەڕان لە خشتەکەدا...">
    </div>

    @if (count($filters) > 0)
        <div class="filter_wrap">
            <button type="button" class="chip_btn" data-filter-toggle aria-expanded="false" aria-controls="filter_panel">
                @include('partials.icon', ['name' => 'filter'])
                <span data-i18n="filter_label">فلتەر</span>
                <span class="filter_badge" data-filter-count hidden>0</span>
            </button>
            <div class="filter_panel" id="filter_panel" data-filter-panel hidden>
                @foreach ($filters as $f)
                    <div class="filter_field">
                        <label for="filter_{{ $f['key'] }}" data-i18n="{{ $f['label_key'] }}">{{ $f['label'] }}</label>
                        @if (array_key_exists($f['key'], $locks))
                            <select id="filter_{{ $f['key'] }}" data-filter="{{ $f['key'] }}" data-lock="{{ $locks[$f['key']] }}" disabled>
                                <option>{{ $locks[$f['key']] }}</option>
                            </select>
                            <p class="field_hint">
                                @include('partials.icon', ['name' => 'lock'])
                                <span data-i18n="filter_locked">قفڵکراوە بۆ بەشەکەت</span>
                            </p>
                        @else
                            <select id="filter_{{ $f['key'] }}" data-filter="{{ $f['key'] }}" @if (($f['kind'] ?? '') === 'bool') data-kind="bool" @endif></select>
                        @endif
                    </div>
                @endforeach
                <button type="button" class="filter_clear" data-filter-clear data-i18n="filter_clear">سڕینەوەی فلتەرەکان</button>
            </div>
        </div>
    @endif
</div>
