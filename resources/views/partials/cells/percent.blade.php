{{-- <td> content for a percentage (10 → 10%, 12.5 → 12.5%). Pass ['value' => $x->discount_percentage] --}}
<bdi dir="ltr" class="num" data-value="{{ (float) $value }}">{{ rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.') }}%</bdi>
