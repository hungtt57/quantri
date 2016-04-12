@extends('admin.layout.master')

@section('title')
Quản lý người dùng
@stop

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/css/dataTables.bootstrap.css') }}">
<!-- Datatables extensions -->
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/extensions/ColReorder/css/colReorder.dataTables.min.css') }}">
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/extensions/FixedColumns/css/fixedColumns.dataTables.min.css') }}">
@endsection

@section('content')

@endsection

@section('js')

<!-- DataTables -->
<script src="{{  url('public/admin/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
<!-- Datatables extensions -->
<script src="{{  url('public/admin/plugins/datatables/extensions/Buttons/js/buttons.print.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{  url('public/admin/specify/jszip.min.js') }}"></script>
<script src="{{  url('public/admin/specify/pdfmake.min.js') }}"></script>
<script src="{{  url('public/admin/specify/vfs_fonts.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Button/js/buttons.html5.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js') }}"></script>
@endsection