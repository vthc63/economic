@extends('layouts.client')
@section('content-client')
<div class="container_fullwidth content-page">
    <div class="container">
      <div class="row">
       <div class="col-12">
        {!! $setting->introduction !!}
       </div>
      </div>
      <div class="clearfix">
      </div>
    </div>
</div>
@endsection