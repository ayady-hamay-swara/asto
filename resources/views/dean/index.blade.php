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
    {{-- DEAN page. College-level overview of all students. --}}
    @php
        $filters = [
            ['key' => 'college',    'label_key' => 'col_college',    'label' => 'کۆلێژ'],
            ['key' => 'department', 'label_key' => 'col_department', 'label' => 'بەش'],
            ['key' => 'stage',      'label_key' => 'col_stage',      'label' => 'قۆناغ'],
            ['key' => 'parallel',   'label_key' => 'col_parallel',   'label' => 'پاراڵێل', 'kind' => 'bool'],
        ];
        $clearanceArea = $clearanceArea ?? 'dean';
        $canModify = in_array($admin->role ?? '', ['dean', 'vice dean']);
    @endphp

    @include('partials.page-header', ['area' => 'dean'])

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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr data-college="{{ $student->college }}" data-department="{{ $student->department }}" data-stage="{{ $student->stage }}" data-parallel="{{ (int) $student->parallel }}">
                            <td><bdi dir="ltr">{{ $student->id }}</bdi></td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->college }}</td>
                            <td>{{ $student->department }}</td>
                            <td>{{ $student->stage }}</td>
                            <td>@include('partials.cells.gender', ['value' => $student->gender])</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone_number }}</td>
                            <td>{{ $student->parallel ? 'بەڵێ' : 'نەخێر' }}</td>
                        </tr>
                    @empty
                        <tr class="empty_row">
                            <td colspan="9" data-i18n="empty_students">هیچ خوێندکارێک نەدۆزرایەوە.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
