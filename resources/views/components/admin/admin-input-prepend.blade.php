@props(['label', 'col' => 'col-12', 'width' => '20%'])
<div class="form-group {{$col}}">
  <div class="input-group">
    <div class="input-group-prepend" style="width:{{$width}};">
      <span class="input-group-text" style="width:100%;">{{$label}}</span>
    </div>
    {{ $slot }}
  </div>
  <!-- /.input group -->
</div>