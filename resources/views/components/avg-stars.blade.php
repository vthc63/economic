@props(['number'])
{{-- @for($i = 1; $i <= floor($number); $i++)
    <i class="fas fa-star"></i>
@endfor
@if (strlen(rtrim($number, '0')) >= 3)
    <i class="fas fa-star-half-alt"></i>
@endif --}}
<div style="display: inline;" class="start-container">
    @for($i = 1; $i <= 5; $i++)
        @if ($i <= floor($number))
            <i class="fas fa-star"></i>
        @else
            @if (strlen(rtrim($number, '0')) >= 3 && floor($number) + 1 == $i)
                <i class="fas fa-star-half-alt"></i>
            @else
                <i class="fas fa-star none"></i>
            @endif
        @endif
    @endfor
</div>
