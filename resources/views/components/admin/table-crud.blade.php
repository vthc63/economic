@props(['headers', 'list', 'actions', 'routes'])
<div class="card">
    <!-- /.card-header -->
    @if ($actions['create'] || $actions['createExcel'] || $actions['deleteAll'])
        <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex">
                @if ($actions['create'])
                    <a 
                        href="{{ (isset($routes['create'])) ? route($routes['create']) : '#'}}" 
                        class="btn btn-primary next-link__js">
                        Thêm Mới
                    </a>
                @endif
                @if ($actions['createExcel'])
                    <button class="btn btn-success ml-1">Excel</button>
                @endif
            </div>
            <div class="col-6 text-right">
                @if ($actions['deleteAll'])
                    <button class="btn btn-danger">Xóa Tất Cả</button>
                @endif
            </div>
        </div>
        </div>
    @endif
    <div class="card-body">
        <table id="table-crud" class="table table-bordered table-striped">
            <thead>
                <tr>
                    @foreach ($headers as $header)
                        <th>{{ $header['text'] }}</th>
                    @endforeach
                    @if($actions['viewDetail'] || $actions['edit'] || $actions['delete'])
                        <th>{{ $actions['text'] }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr id="{{ $item->id }}">
                        @foreach ($headers as $header)
                            <td>
                                @if (! isset($header['status']) && ! isset($header['img']))
                                    @php
                                        $value = is_array($item_value = data_get($item, $header['key'])) ? nl2br(implode(PHP_EOL, $item_value)) : $item_value 
                                    @endphp
                                    @if (isset($header['format']))
                                        {{ format_number_to_money ($value) }}
                                    @else
                                        {{$value}}
                                    @endif
                                @elseif (isset($header['img']))
                                    @php
                                        $value = is_array($item_value = data_get($item, $header['key'])) ? nl2br(implode(PHP_EOL, $item_value)) : $item_value 
                                    @endphp
                                    <img style="{{ $header['img']['style'] }}" src="{{ asset($header['img']['url']) . '/' . $value }}" alt="">
                                @else
                                    @foreach ($header['status'] as $status)
                                        @php
                                            $value = is_array($item_value = data_get($item, $header['key'])) ? nl2br(implode(PHP_EOL, $item_value)) : $item_value 
                                        @endphp
                                        @if ($value == $status['value'])
                                            <span class="{{ $status['class'] }}">{{$status['text']}}</span>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        @endforeach
                        @if($actions['viewDetail'] || $actions['edit'] || $actions['delete'])
                            <td>
                                @if ($actions['edit'])
                                    <a href="{{ isset($routes['edit']) ? route($routes['edit'], $item->id) : '#' }}" id="edit-customer" class="btn btn-primary next-link__js">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if ($actions['viewDetail'])
                                    <button id="btn-table-view-detail__js" class="btn btn-info">
                                        <i class="fas fa-history"></i>
                                    </button>
                                @endif
                                @if ($actions['delete'])
                                    <form style="display: inline;" action="{{route($routes['delete'])}}" method="POST" id="form-delete__js">
                                        @csrf
                                        <input type="text" name="id" value="{{$item->id}}" hidden>
                                    </form>
                                    <button id="delete__js" class="btn btn-danger" url="{{route($routes['delete'])}}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@vite(['resources/admin/js/table-data.js', 'resources/admin/js/toast-message.js'])
