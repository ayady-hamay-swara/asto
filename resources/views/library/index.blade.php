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
    {{-- LIBRARY page. One row per borrowed book. Expects $loans (student_name, student_id, book_title, borrowed_at, returned_at; returned_at empty = not returned yet). --}}
    @php
        $filters = [
            ['key' => 'returned', 'label_key' => 'filter_returned', 'label' => 'گەڕاوەتەوە', 'kind' => 'bool'],
        ];
    @endphp

    @include('partials.page-header', ['area' => 'library'])

    <section class="table_tools" data-table-tools>
        @include('partials.table-toolbar', ['filters' => $filters])

        <div class="table">
            <table>
                <thead>
                    <tr>
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_name', 'label' => 'ناو'])
                        @include('partials.th', ['type' => 'number', 'i18n' => 'col_id', 'label' => 'ژمارە'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'lib_col_book', 'label' => 'کتێب'])
                        @include('partials.th', ['type' => 'date', 'i18n' => 'lib_col_borrowed', 'label' => 'بەرواری وەرگرتن'])
                        @include('partials.th', ['type' => 'date', 'i18n' => 'lib_col_returned', 'label' => 'بەرواری گەڕاندنەوە'])
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr data-returned="{{ $loan->returned_at ? 1 : 0 }}">
                            <td>{{ $loan->student_name }}</td>
                            <td><bdi dir="ltr">{{ $loan->student_id }}</bdi></td>
                            <td>{{ $loan->book_title }}</td>
                            <td>@include('partials.cells.date', ['value' => $loan->borrowed_at])</td>
                            @if ($loan->returned_at)
                                <td>@include('partials.cells.date', ['value' => $loan->returned_at])</td>
                            @else
                                <td class="muted_cell" data-value="" data-i18n="lib_not_returned">هێشتا نەگەڕاوەتەوە</td>
                            @endif
                        </tr>
                    @empty
                        <tr class="empty_row">
                            <td colspan="5" data-i18n="lib_empty">هیچ کتێبێک وەرنەگیراوە.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
