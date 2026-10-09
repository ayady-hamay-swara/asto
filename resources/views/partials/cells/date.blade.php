{{-- <td> content for a date (string or Carbon), kept left-to-right inside RTL rows. Pass ['value' => $x->created_at] --}}
<bdi dir="ltr">{{ $value ? date('Y-m-d', strtotime((string) $value)) : '—' }}</bdi>
