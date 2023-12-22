@props(['id', 'type', 'value' => null, 'name', 'placeholder'])
<input id="{{$id}}" type="{{ $type }}" class="form-control" value="{{ $value }}" name="{{ $name }}" placeholder="{{ $placeholder }}">