{{-- Title + area label on one side, the two buttons on the other.
     Pass ['area' => 'finance'|'law'|'library'|'registration'|'department', 'subtitle' => 'optional text'] --}}
@php $areaNames = ['finance' => 'دارایی', 'law' => 'یاسا', 'library' => 'کتێبخانە', 'registration' => 'تۆمارگە', 'department' => 'بەش']; @endphp
<header class="page_head">
    <div class="page_title">
        <h2 data-i18n="db_title">بنکەی زانیاری</h2>
        <p class="area_line">
            <span class="area_label" data-i18n="area_{{ $area }}">{{ $areaNames[$area] ?? '' }}</span>
            @if (!empty($subtitle))
                <span class="area_sub">{{ $subtitle }}</span>
            @endif
        </p>
    </div>
    @include('partials.page-actions')
</header>
