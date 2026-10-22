@extends('layouts.app')

@section('title_key', 'db_title')
@section('title_text', 'بنکەی زانیاری')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/data-page.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/table-tools.js') }}"></script>
    <script>
        // Handle clearance toggle
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.clearance-toggle').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const studentId = this.dataset.studentId;
                    const area = this.dataset.area;
                    const status = this.checked;

                    fetch('/api/clearance/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            student_id: studentId,
                            area: area,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            // Revert checkbox on error
                            this.checked = !status;
                            alert('Error updating clearance: ' + (data.error || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        this.checked = !status;
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
@endpush

@section('content')
    {{-- LAW page. Student columns + law clearance from department database. --}}
    @php
        $filters = [
            ['key' => 'college',    'label_key' => 'col_college',    'label' => 'کۆلێژ'],
            ['key' => 'department', 'label_key' => 'col_department', 'label' => 'بەش'],
            ['key' => 'stage',      'label_key' => 'col_stage',      'label' => 'قۆناغ'],
            ['key' => 'parallel',   'label_key' => 'col_parallel',   'label' => 'پاراڵێل', 'kind' => 'bool'],
            ['key' => 'law_cleared', 'label_key' => 'col_law_cleared', 'label' => 'یاسا', 'kind' => 'bool'],
        ];
        $clearanceArea = $clearanceArea ?? 'law';
        $canModify = in_array($admin->role ?? '', ['law officer', 'chairman', 'assistant head']);
    @endphp

    @include('partials.page-header', ['area' => 'law'])

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
                        @include('partials.th', ['type' => 'bool', 'i18n' => 'col_law_cleared', 'label' => 'یاسا'])
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        @php
                            $clearance = $clearances->get($student->id);
                            $isCleared = $clearance ? $clearance->law_cleared : true;
                            $studentDept = $student->department;
                            $isOwnDept = $studentDept === ($admin->department ?? '');
                        @endphp
                        <tr data-college="{{ $student->college }}" data-department="{{ $student->department }}" data-stage="{{ $student->stage }}" data-parallel="{{ (int) $student->parallel }}" data-law-cleared="{{ (int) $isCleared }}">
                            <td><bdi dir="ltr">{{ $student->id }}</bdi></td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->college }}</td>
                            <td>{{ $student->department }}</td>
                            <td>{{ $student->stage }}</td>
                            <td>@include('partials.cells.gender', ['value' => $student->gender])</td>
                            <td><bdi dir="ltr">{{ $student->email }}</bdi></td>
                            <td><bdi dir="ltr">{{ $student->phone_number }}</bdi></td>
                            <td>@include('partials.cells.bool', ['value' => $student->parallel])</td>
                            <td>
                                @if ($canModify && $isOwnDept)
                                    <input type="checkbox" class="clearance-toggle" data-student-id="{{ $student->id }}" data-area="law" {{ $isCleared ? 'checked' : '' }}>
                                @else
                                    @include('partials.cells.bool', ['value' => $isCleared])
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="empty_row">
                            <td colspan="10" data-i18n="students_empty">هیچ خوێندکارێک نەدۆزرایەوە.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
