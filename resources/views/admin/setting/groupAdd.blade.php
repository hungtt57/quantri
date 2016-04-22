@extends('admin.layout.master')

@section('title')
Cài đặt
@endsection
@section('css')
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/css/dataTables.bootstrap.css') }}">
<style type="text/css">
	.btn-cancel{
	background-color: #abbac3!important;
    border-color: #abbac3;
    color: #fff;
	}
	.center{
		    text-align: center!important;
	}
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Thêm mới nhóm thiết lập</h1>
	</div>
	<div class="col-xs-12 col-sm-9 col-md-8 col-lg-7 ">
		<form class="form-horizontal" method="post" action="{{asset('/setting/group/add')}}" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group required">
				<label for="SettingGroupKey" class="col-xs-12 col-sm-3 control-label no-padding-right">Key</label>
				<div class="col-xs-12 col-sm-9">
					<input name="key" isbridge="1" class="form-control" maxlength="50" type="text" id="SettingGroupKey" required="required">
				</div>
			</div>
			<div class="form-group required">
				<label for="SettingGroupKey" class="col-xs-12 col-sm-3 control-label no-padding-right">Name</label>
				<div class="col-xs-12 col-sm-9">
					<input name="name" isbridge="1" class="form-control" maxlength="50" type="text" id="SettingGroupKey" required="required">
				</div>
			</div>

			<div class="form-group">
				<label for="SettingGroupDescription" class="col-xs-12 col-sm-3 control-label no-padding-right">Description</label>
				<div class="col-xs-12 col-sm-9">
					<textarea name="description" class="form-control" isbridge="1" cols="30" rows="6" id="SettingGroupDescription"></textarea>
				</div>
			</div>

			<!-- <div class="form-group required">
				<label for="SettingGroupKey" class="col-xs-12 col-sm-3 control-label no-padding-right">System</label>
				<div class="col-xs-12 col-sm-9">
					<input name="data[SettingGroup][key]" isbridge="1" class="form-control" maxlength="50" type="text" id="SettingGroupKey" required="required">
				</div>
			</div> -->
			<div class="form-group">
				<label for="SettingGroupOrdernum" class="col-xs-12 col-sm-3 control-label no-padding-right">Ordernum</label>
				<div class="col-xs-12 col-sm-9">
					<input name="order" isbridge="1" class="form-control" type="number" id="SettingGroupOrdernum">
				</div>
			</div>
			<div class="center">
		    <a href="{{asset('setting/group')}}" class="btn btn-sm btn-cancel">Cancel</a>&nbsp;&nbsp;
		    <button type="submit" id="frm_SettingGroup_save" class="btn btn-sm btn-info"><i class="icon-ok bigger-110"></i> Save &amp; Close</button>  
		    </div>
		</form>

	</div>
</div>
<!-- /.row -->
@endsection

