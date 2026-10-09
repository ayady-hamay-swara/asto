@extends('layouts.app')

@section('title_key', 'db_title')
@section('title_text', 'بنکەی زانیاری')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/students.css') }}">
@endpush

@section('content')
    @php
        // Controller passes: $area (finance|law|library|registration), $tab (students|teachers|staff), $students
        $area = $area ?? 'registration';
        $tab  = $tab ?? 'students';
        $areaNames = ['finance' => 'دارایی', 'law' => 'یاسا', 'library' => 'کتێبخانە', 'registration' => 'تۆمارگە'];
        $tabs = ['students' => 'خوێندکار', 'teachers' => 'مامۆستا', 'staff' => 'کارمەند'];
    @endphp

    <header class="page_head">
        <div class="page_title">
            <h2 data-i18n="db_title">بنکەی زانیاری</h2>
            <span class="area_label" data-i18n="area_{{ $area }}">{{ $areaNames[$area] ?? '' }}</span>
        </div>
        @include('partials.page-actions')
    </header>

    <nav class="tabs">
        <div class="tab_name">
            @foreach ($tabs as $key => $fallback)
                <a href="{{ request()->fullUrlWithQuery(['tab' => $key]) }}"
                   class="tab{{ $tab === $key ? ' is_active' : '' }}"
                   @if ($tab === $key) aria-current="page" @endif
                   data-i18n="tab_{{ $key }}">{{ $fallback }}</a>
            @endforeach
        </div>
    </nav>

    @if ($tab === 'students')
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th scope="col" data-i18n="col_name">ناو</th>
                        <th scope="col" data-i18n="col_id">ژمارە</th>
                        <th scope="col" data-i18n="col_college">کۆلێژ</th>
                        <th scope="col" data-i18n="col_department">بەش</th>
                        <th scope="col" data-i18n="col_stage">قۆناغ</th>
                        <th scope="col" data-i18n="col_gender">ڕەگەز</th>
                        <th scope="col" data-i18n="col_email">ئیمەیل</th>
                        <th scope="col" data-i18n="col_phone">مۆبایل</th>
                        <th scope="col" data-i18n="col_parallel">پاراڵێل</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        @php $g = strtolower((string) ($student->gender ?? '')); @endphp
                        <tr>
                            <td>
                                <div class="profile_name">
                                    <img src="{{ asset('img/avatar.svg') }}" alt="" width="40" height="40">
                                    <span>{{ $student->name }}</span>
                                </div>
                            </td>
                            <td><bdi dir="ltr">{{ $student->id }}</bdi></td>
                            <td>{{ $student->college }}</td>
                            <td>{{ $student->department }}</td>
                            <td>{{ $student->stage }}</td>
                            <td>
                                @if (in_array($g, ['male', 'm'], true))
                                    <span data-i18n="gender_male">نێر</span>
                                @elseif (in_array($g, ['female', 'f'], true))
                                    <span data-i18n="gender_female">مێ</span>
                                @else
                                    <span data-i18n="gender_unspecified">دیارینەکراو</span>
                                @endif
                            </td>
                            <td><bdi dir="ltr">{{ $student->email }}</bdi></td>
                            <td><bdi dir="ltr">{{ $student->phone_number }}</bdi></td>
                            <td>
                                @if ($student->parallel)
                                    <span data-i18n="yes">بەڵێ</span>
                                @else
                                    <span data-i18n="no">نەخێر</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="empty_row">
                            <td colspan="9" data-i18n="students_empty">هیچ خوێندکارێک نەدۆزرایەوە.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <p class="empty_note" data-i18n="tab_empty">هێشتا هیچ زانیارییەک لەم بەشەدا نییە.</p>
    @endif
@endsection
