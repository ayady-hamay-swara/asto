@extends('layouts.app')

@section('title_key', 'db_title')
@section('title_text', 'بنکەی زانیاری')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/data-page.css') }}">
@endpush

@section('content')
    {{-- Books each student borrowed and returned. Expects $loans (student_name, student_id, book_title, borrowed_at, returned_at). --}}
    @include('partials.page-header', ['area' => 'library'])

    <div class="table">
        <table>
            <thead>
                <tr>
                    <th scope="col" data-i18n="col_name">ناو</th>
                    <th scope="col" data-i18n="col_id">ژمارە</th>
                    <th scope="col" data-i18n="lib_col_book">کتێب</th>
                    <th scope="col" data-i18n="lib_col_borrowed">بەرواری وەرگرتن</th>
                    <th scope="col" data-i18n="lib_col_returned">بەرواری گەڕاندنەوە</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr>
                        <td>{{ $loan->student_name }}</td>
                        <td><bdi dir="ltr">{{ $loan->student_id }}</bdi></td>
                        <td>{{ $loan->book_title }}</td>
                        <td>@include('partials.cells.date', ['value' => $loan->borrowed_at])</td>
                        @if ($loan->returned_at)
                            <td>@include('partials.cells.date', ['value' => $loan->returned_at])</td>
                        @else
                            <td class="muted_cell" data-i18n="lib_not_returned">هێشتا نەگەڕاوەتەوە</td>
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
@endsection
