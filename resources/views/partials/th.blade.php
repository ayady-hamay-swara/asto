{{-- Sortable column header. Pass ['type' => 'text'|'number'|'date'|'bool', 'i18n' => 'col_name', 'label' => 'ناو'] --}}
<th scope="col" data-type="{{ $type ?? 'text' }}" aria-sort="none">
    <button type="button" class="sort_btn" data-sort>
        <span data-i18n="{{ $i18n }}">{{ $label }}</span>
        @include('partials.icon', ['name' => 'sort'])
    </button>
</th>
