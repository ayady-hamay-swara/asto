{{-- Title + area label on one side, the two buttons on the other. Pass ['area' => 'finance'|'law'|'library'|'registration'] --}}
@php $areaNames = ['finance' => 'دارایی', 'law' => 'یاسا', 'library' => 'کتێبخانە', 'registration' => 'تۆمارگە']; @endphp
<header class="page_head">
    <div class="page_title">
        <h2 data-i18n="db_title">بنکەی زانیاری</h2>
        <span class="area_label" data-i18n="area_{{ $area }}">{{ $areaNames[$area] ?? '' }}</span>
    </div>
    @include('partials.page-actions')
</header>
