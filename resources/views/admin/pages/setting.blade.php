@extends('admin.layout.master')

@section('title')
Cài đặt
@endsection
@section('css')
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/css/dataTables.bootstrap.css') }}">

@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Cài đặt</h1>
	</div>
	<div class="col-xs-12 no-padding-left no-padding-right">
		<div class="row">
			<div class="col-xs-12 col-sm-9 col-lg-10">
				<a class="btn btn-sm btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i> New Setting</a>
				<a class="btn btn-sm btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i> Manager Type</a>
				<a class="btn btn-sm btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i> Manager Group</a>
			</div>
			<div class="col-xs-12 col-sm-3 col-lg-2 form-group" style="padding-top:5px">
				<select class="form-control chosen-select">
					<option>TEST 1</option>
					<option>TEST 2</option>
				</select>
			</div>
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<ul class="nav nav-tabs padding-12 background-blue">
					<li class="active"><a href="#tab_a" data-toggle="tab">Tab A</a></li>
					<li><a href="#tab_b" data-toggle="tab">Tab B</a></li>
					<li><a href="#tab_c" data-toggle="tab">Tab C</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_a">
						<form style="margin-top: 15px;">
							<div class="table-responsive">
								<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th></th>
											<th>#</th>
											<th>Key</th>
											<th>Value</th>
										</tr>
									</thead>
									<tfoot>
										<tr><td colspan="4" style="border-left:0px;border-right:0px" rowspan="1">
											<div class="clearfix">
												<button type="submit" id="" class="btn btn-sm btn-info"><i class="icon-ok bigger-110"></i> Save</button>                    </div>
											</td></tr>
										</tfoot>
										<tbody>
											<tr>
												<td>A</td>
												<td>B</td>
												<td>C</td>
												<td>D</td>

											</tr>
											<tr>
												<td>A</td>
												<td>B</td>
												<td>C</td>
												<td>D</td>

											</tr>

										</tbody>
									</table>
								</div>
							</form>
						</div>
						<div class="tab-pane" id="tab_b">
							<h4>Pane B</h4>
							<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames
								ac turpis egestas.</p>
							</div>
							<div class="tab-pane" id="tab_c">
								<h4>Pane C</h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames
									ac turpis egestas.</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- /.row -->
			@endsection

			@section('js')

			<script src="{{  url('public/admin/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
			<script src="{{  url('public/admin/plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
			<script type="text/javascript">
				$(document).ready(function() {
					var table = $('#example').DataTable();
				} );

			</script>
			@endsection