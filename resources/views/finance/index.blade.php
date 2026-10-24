@extends('layouts.app')

@section('title_key', 'db_title')
@section('title_text', 'بنکەی زانیاری')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/data-page.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/table-tools.js') }}"></script>
@endpush

@section('content')
    {{-- FINANCE page. Student columns + the finance record (tuition_fee, discount_percentage, fee_after_discount, paid_amount, remaining_amount) + this area's clearance (cleared = finished this area's clearance project). Change freely: this table belongs to finance only. --}}
    @php
        $filters = [
            ['key' => 'college',    'label_key' => 'col_college',    'label' => 'کۆلێژ'],
            ['key' => 'department', 'label_key' => 'col_department', 'label' => 'بەش'],
            ['key' => 'stage',      'label_key' => 'col_stage',      'label' => 'قۆناغ'],
            ['key' => 'parallel',   'label_key' => 'col_parallel',   'label' => 'پاراڵێل', 'kind' => 'bool'],
            ['key' => 'cleared',    'label_key' => 'col_cleared',    'label' => 'بەرائەت',  'kind' => 'bool'],
        ];
    @endphp

    @include('partials.page-header', ['area' => 'finance'])

    <section class="table_tools" data-table-tools>
        @include('partials.table-toolbar', ['filters' => $filters])

        <div class="table">
            <table>
                <thead>
                    <tr>
                        @include('partials.th', ['type' => 'number', 'i18n' => 'col_id', 'label' => 'ژمارە'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_name', 'label' => 'ناو'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_college', 'label' => 'کۆلێژ'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_department', 'label' => 'بەش'])
                        @include('partials.th', ['type' => 'number', 'i18n' => 'col_stage', 'label' => 'قۆناغ'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_gender', 'label' => 'ڕەگەز'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_email', 'label' => 'ئیمەیل'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_phone', 'label' => 'مۆبایل'])
                        @include('partials.th', ['type' => 'bool', 'i18n' => 'col_parallel', 'label' => 'پاراڵێل'])
                        @include('partials.th', ['type' => 'number', 'i18n' => 'fin_tuition_fee', 'label' => 'کرێی خوێندن'])
                        @include('partials.th', ['type' => 'number', 'i18n' => 'fin_discount', 'label' => 'ڕێژەی داشکاندن'])
                        @include('partials.th', ['type' => 'number', 'i18n' => 'fin_fee_after_discount', 'label' => 'کرێی دوای داشکاندن'])
                        @include('partials.th', ['type' => 'number', 'i18n' => 'fin_paid', 'label' => 'بڕی دراو'])
                        @include('partials.th', ['type' => 'number', 'i18n' => 'fin_remaining', 'label' => 'بڕی ماوە'])
                        @include('partials.th', ['type' => 'bool', 'i18n' => 'col_cleared', 'label' => 'بەرائەت'])
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr data-college="{{ $student->college }}" data-department="{{ $student->department }}" data-stage="{{ $student->stage }}" data-parallel="{{ (int) $student->parallel }}" data-cleared="{{ (int) $student->cleared }}">
                            <td><bdi dir="ltr">{{ $student->id }}</bdi></td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->college }}</td>
                            <td>{{ $student->department }}</td>
                            <td>{{ $student->stage }}</td>
                            <td>@include('partials.cells.gender', ['value' => $student->gender])</td>
                            <td><bdi dir="ltr">{{ $student->email }}</bdi></td>
                            <td><bdi dir="ltr">{{ $student->phone_number }}</bdi></td>
                            <td>@include('partials.cells.bool', ['value' => $student->parallel])</td>
                            <td>@include('partials.cells.money', ['value' => $student->finance?->tuition_fee ?? 0])</td>
                            <td>@include('partials.cells.percent', ['value' => $student->finance?->discount_percentage ?? 0])</td>
                            <td>@include('partials.cells.money', ['value' => $student->finance?->fee_after_discount ?? 0])</td>
                            <td>@include('partials.cells.money', ['value' => $student->finance?->paid_amount ?? 0])</td>
                            <td>@include('partials.cells.money', ['value' => $student->finance?->remaining_amount ?? 0])</td>
                            <td>@include('partials.cells.bool', ['value' => $student->cleared])</td>
                        </tr>
                    @empty
                        <tr class="empty_row">
                            <td colspan="15" data-i18n="students_empty">هیچ خوێندکارێک نەدۆزرایەوە.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
