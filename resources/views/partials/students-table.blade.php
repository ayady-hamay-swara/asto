{{-- Read-only students table. Pass ['students' => $students]. Area pages add their own actions around it. --}}
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
                    <td>{{ $student->name }}</td>
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
