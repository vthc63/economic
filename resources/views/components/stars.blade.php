@props(['number'])
@for ($i = 1; $i <= 5; $i++)
    @if ($i <= $number)
        <i class="fas fa-star"></i>
    @else
        <i class="fas fa-star star-none"></i>
    @endif
@endfor