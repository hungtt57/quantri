@extends('admin.layout.master')

@section('title')
Dashboard
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{Setting::get('system.App.Name')}}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@endsection