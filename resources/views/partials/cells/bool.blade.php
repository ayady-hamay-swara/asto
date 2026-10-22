{{-- <td> content for a yes/no value: an empty box means no, a ticked box means yes. Pass ['value' => $x->parallel] --}}
@php $on = (bool) ($value ?? false); @endphp
<span class="check_box{{ $on ? ' is_checked' : '' }}" role="img" data-value="{{ $on ? 1 : 0 }}" data-i18n-aria="{{ $on ? 'yes' : 'no' }}" aria-label="{{ $on ? 'بەڵێ' : 'نەخێر' }}">
    @if ($on)
        @include('partials.icon', ['name' => 'check'])
    @endif
</span>
