{{-- <td> content for a date (string or Carbon), kept left-to-right inside RTL rows. Pass ['value' => $x->created_at] --}}
@php $iso = $value ? date('Y-m-d', strtotime((string) $value)) : ''; @endphp
<bdi dir="ltr" data-value="{{ $iso }}">{{ $iso !== '' ? $iso : '—' }}</bdi>
