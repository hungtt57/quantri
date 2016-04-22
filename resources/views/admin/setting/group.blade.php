@extends('admin.layout.master')

@section('title')
Cài đặt
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{asset('public/admin/css/setting.css')}}">
<style type="text/css">
	
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Cài đặt</h1>
	</div>
	<div class="col-xs-12 no-padding-left no-padding-right">
		<div class="row">
			<div class="col-xs-12 col-sm-9 col-lg-10">
				<a class="btn btn-sm btn-primary" style="margin-top:5px" href="{{asset('setting/group/add')}}"><i class="fa fa-plus" aria-hidden="true"></i> New Group</a>
				<a class="btn btn-sm btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i> Manager Type</a>
				<a class="btn btn-sm btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i> Manager Setting</a>
			</div>
			<div class="col-xs-12 col-sm-3 col-lg-2 form-group" style="padding-top:5px">
				<select class="form-control chosen-select">
					<option>TEST 1</option>
					<option>TEST 2</option>
				</select>
			</div>
			<div class="col-xs-12 col-sm-12 col-lg-12" >
				
				
				<form style="margin-top: 15px;">
					<div >
						<table id="example" class="display table table-responsive table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th   style=" width:30px; "></th>
									<th   style=" width:14px; ">#</th>
									<th  >Key</th>
									<th  >Value</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="4" style="border-left:0px;border-right:0px" rowspan="1">
									<div class="clearfix">
										<button type="submit" id="" class="btn btn-sm btn-info"><i class="icon-ok bigger-110"></i> Save</button>                    </div>
									</td>
								</tr>
							</tfoot>
							<tbody>
								<tr>
									<td style=" width:30px; "><button class="btn btn-warning open-edit-user-modal"><span class="glyphicon glyphicon-pencil"></span></button></td>
									<td style=" width:14px; ">1</td>
									<td>C</td>
									<td style="border-right:0px, line-height: 25px;">
										<textarea name="" class="autosize-transition form-control" isbridge="1" placeholder="Value" style="margin: 0px; overflow: hidden; word-wrap: break-word; resize: horizontal; height: 50px;width: 100%;" rows="1" cols="30" id="Setting0Value">false</textarea>
									</td>

								</tr>

							</tbody>
						</table>
					</div>
				</form>
			</div>

		</div>
		<!-- /.row -->
		@endsection

		@section('js')

		<script src="{{  url('public/admin/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{  url('public/admin/plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var table = $('#example').dataTable({
					columns: [
					{
						"visible": true, 
						"searchable": false, 
						"orderable": false
					},
					{
						"visible": true, 
						"searchable": false, 
						"orderable": false
					},
					{
						"visible": true, 
						"searchable": false, 
						"orderable": false
					},
					{
						"visible": true, 
						"searchable": false, 
						"orderable": false
					}
					],
					sorting: []
				});
			} );

		</script>
		@endsection