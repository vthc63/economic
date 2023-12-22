@props(['route', 'cancel', 'fields', 'rules' => '', 'messages' => '', 'textSubmit' => 'Thêm Mới', 'cancelBtn' => "true"])

<div id="form-data" hidden data-rules="{{ json_encode($rules) }}"
        data-messages="{{ json_encode($messages) }}"></div>
<form action="{{ $route }}" method="POST" id="form__js" enctype="multipart/form-data">
  @csrf
  <!-- /.card-header -->
  <div class="card-body">
    @foreach ($fields as $field)
    <x-admin-input-prepend label="{{$field['label']}}">
      @if ($field['type'] == 'select')
        <select class="form-control" name="{{$field['attribute']}}" id="{{$field['attribute']}}">
          @if (isset($field['list']))
            @foreach ($field['list'] as $option)
                <option value="{{$option['value']}}"
                @if (old($field['attribute']))
                  @php if (old($field['attribute']) == $option['value']) echo "selected"; @endphp
                @elseif(isset($field['value']))
                  @php if ($field['value'] == $option['value']) echo "selected"; @endphp
                @endif
                >{{$option['text']}}</option>
            @endforeach
          @endif
        </select>
      @elseif($field['type'] == 'file')
      <div class="custom-file">
        <input type="file" name="{{$field['attribute']}}" class="custom-file-input inputFile__js" id="{{$field['attribute']}}">
        <label class="custom-file-label" for="inputFile__js">Chọn hình ảnh</label>
      </div>
      @else
      <input 
        id="{{$field['attribute']}}"
        type="{{$field['type']}}" 
        value="{{old($field['attribute']) ?? $field['value'] ?? null }}" 
        name="{{$field['attribute']}}"
        autocomplete="{{$field['autocomplete'] ?? null}}"
        {{$field['other'] ?? null}}
        @if (isset($field['format_phone']))
          data-inputmask='"mask": "999 999-9999"' data-mask
        @endif
        class="form-control">
      @endif
      @if ($errors->get($field['attribute']))
        <span id="{{$field['attribute']}}-error" class="error invalid-feedback" style="display: block">
          {{ implode(", ",$errors->get($field['attribute'])) }}
        </span>
      @endif
    </x-admin-input-prepend >
    @endforeach  
    <!-- /.row -->
  </div>
  <!-- /.card-body -->
  <div class="card-header text-center">
    <button class="btn btn-success">{{$textSubmit}}</button>
    @if ($cancelBtn == "true")
      <a href="{{ route($cancel) }}" class="btn btn-danger next-link__js">Hủy</a>
    @endif
  </div>
</form>
@vite(['resources/common/js/form.js','resources/common/css/form.css'])