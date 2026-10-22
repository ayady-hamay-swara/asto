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
    {{-- DEPARTMENT page: the department manages its own students. Shows all clearance areas from department database. --}}
    @php
        // The department is fixed to the signed-in department member's own department.
        $department = $department ?? '';
        $filters = [
            ['key' => 'department',   'label_key' => 'col_department',   'label' => 'بەش'],
            ['key' => 'stage',        'label_key' => 'col_stage',        'label' => 'قۆناغ'],
            ['key' => 'registration', 'label_key' => 'area_registration', 'label' => 'تۆمارگە', 'kind' => 'bool'],
            ['key' => 'law',          'label_key' => 'area_law',          'label' => 'یاسا',    'kind' => 'bool'],
            ['key' => 'library',      'label_key' => 'area_library',      'label' => 'کتێبخانە', 'kind' => 'bool'],
            ['key' => 'finance',      'label_key' => 'area_finance',      'label' => 'دارایی',   'kind' => 'bool'],
            ['key' => 'parallel',     'label_key' => 'col_parallel',      'label' => 'پاراڵێل',  'kind' => 'bool'],
        ];
        $locks = ['department' => $department];
        $canModify = in_array($admin->role ?? '', ['chairman', 'assistant head']);
    @endphp

    @include('partials.page-header', ['area' => 'department', 'subtitle' => $department])

    <section class="table_tools" data-table-tools>
        @include('partials.table-toolbar', ['filters' => $filters, 'locks' => $locks])

        <div class="table">
            <table>
                <thead>
                    <tr>
                        @include('partials.th', ['type' => 'number', 'i18n' => 'col_id', 'label' => 'ژمارە'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_name', 'label' => 'ناو'])
                        @include('partials.th', ['type' => 'number', 'i18n' => 'col_stage', 'label' => 'قۆناغ'])
                        @include('partials.th', ['type' => 'text', 'i18n' => 'col_email', 'label' => 'ئیمەیل'])
                        @include('partials.th', ['type' => 'bool', 'i18n' => 'area_registration', 'label' => 'تۆمارگە'])
                        @include('partials.th', ['type' => 'bool', 'i18n' => 'area_law', 'label' => 'یاسا'])
                        @include('partials.th', ['type' => 'bool', 'i18n' => 'area_library', 'label' => 'کتێبخانە'])
                        @include('partials.th', ['type' => 'bool', 'i18n' => 'col_parallel', 'label' => 'پاراڵێل'])
                        @include('partials.th', ['type' => 'bool', 'i18n' => 'area_finance', 'label' => 'دارایی'])
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        @php
                            $clearance = $clearances->get($student->id);
                            $regCleared = $clearance ? $clearance->registration_cleared : true;
                            $lawCleared = $clearance ? $clearance->law_cleared : true;
                            $libCleared = $clearance ? $clearance->library_cleared : true;
                            $finCleared = $clearance ? $clearance->finance_cleared : true;
                        @endphp
                        <tr data-department="{{ $department }}" data-stage="{{ $student->stage }}" data-registration="{{ (int) $regCleared }}" data-law="{{ (int) $lawCleared }}" data-library="{{ (int) $libCleared }}" data-finance="{{ (int) $finCleared }}" data-parallel="{{ (int) $student->parallel }}">
                            <td><bdi dir="ltr">{{ $student->id }}</bdi></td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->stage }}</td>
                            <td><bdi dir="ltr">{{ $student->email }}</bdi></td>
                            <td>
                                @if ($canModify)
                                    <input type="checkbox" class="clearance-toggle" data-student-id="{{ $student->id }}" data-area="registration" {{ $regCleared ? 'checked' : '' }}>
                                @else
                                    @include('partials.cells.bool', ['value' => $regCleared])
                                @endif
                            </td>
                            <td>
                                @if ($canModify)
                                    <input type="checkbox" class="clearance-toggle" data-student-id="{{ $student->id }}" data-area="law" {{ $lawCleared ? 'checked' : '' }}>
                                @else
                                    @include('partials.cells.bool', ['value' => $lawCleared])
                                @endif
                            </td>
                            <td>
                                @if ($canModify)
                                    <input type="checkbox" class="clearance-toggle" data-student-id="{{ $student->id }}" data-area="library" {{ $libCleared ? 'checked' : '' }}>
                                @else
                                    @include('partials.cells.bool', ['value' => $libCleared])
                                @endif
                            </td>
                            <td>@include('partials.cells.bool', ['value' => $student->parallel])</td>
                            <td>
                                @if ($canModify)
                                    <input type="checkbox" class="clearance-toggle" data-student-id="{{ $student->id }}" data-area="finance" {{ $finCleared ? 'checked' : '' }}>
                                @else
                                    @include('partials.cells.bool', ['value' => $finCleared])
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
    </section>
@endsection
