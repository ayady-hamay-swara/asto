@extends('layouts.app')

@section('title_key', 'db_title')
@section('title_text', 'بنکەی زانیاری')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/data-page.css') }}">
@endpush

@section('content')
    {{-- Starting point: the student columns. Change the columns freely, this table belongs to finance only. --}}
    @include('partials.page-header', ['area' => 'finance'])

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
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td><bdi dir="ltr">{{ $student->id }}</bdi></td>
                        <td>{{ $student->college }}</td>
                        <td>{{ $student->department }}</td>
                        <td>{{ $student->stage }}</td>
                        <td>@include('partials.cells.gender', ['value' => $student->gender])</td>
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
@endsection
