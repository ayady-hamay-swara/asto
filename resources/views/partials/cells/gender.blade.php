{{-- <td> content for a gender value. Pass ['value' => $student->gender] --}}
@php $g = strtolower((string) ($value ?? '')); @endphp
@if (in_array($g, ['male', 'm'], true))
    <span data-i18n="gender_male">نێر</span>
@elseif (in_array($g, ['female', 'f'], true))
    <span data-i18n="gender_female">مێ</span>
@else
    <span data-i18n="gender_unspecified">دیارینەکراو</span>
@endif
