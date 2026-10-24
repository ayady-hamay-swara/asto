{{-- <td> content for an amount, left-to-right with thousands separators. Pass ['value' => $x->paid_amount] --}}
<bdi dir="ltr" class="num" data-value="{{ (float) $value }}">{{ number_format((float) $value, 2) }}</bdi>
