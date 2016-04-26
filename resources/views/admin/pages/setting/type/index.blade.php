@extends('admin.layout.master')

@section('title')
Quản lý loại cài đặt
@endsection

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Nhóm cài đặt</h1>
	</div>
	<div class="col-xs-12 no-padding-left no-padding-right">
		<div class="row">
			<div class="col-xs-12 col-sm-9 col-lg-10">
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting/type/add') }}"><i class="fa fa-plus" aria-hidden="true"></i> Thêm loại cài đặt</a>
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting/group') }}">Quản lý nhóm cài đặt</a>
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting') }}">Quản lý cài đặt</a>
			</div>
			<div class="col-xs-12 col-sm-3 col-lg-2 form-group" style="padding-top:5px">
				<select class="form-control chosen-select">
					@foreach($groups as $group)
					<option value="{{ $group->key }}">{{ $group->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-12 col-sm-12 col-lg-12" >		
				<form style="margin-top: 15px;">
					<div >
						<table id="typeSettingList" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th></th>
									<th>#</th>
									<th>Key</th>
									<th>Value</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="4" rowspan="1">
										<button type="submit" id="" class="btn btn-info"><i class="fa fa-check"></i> Lưu</button>
									</td>
								</tr>
							</tfoot>
							<tbody>
								@foreach($types as $type)
								<tr>
									<td><a href="#"><i class="fa fa-pencil"></i></a></td>
									<td></td>
									<td>
										<input type="text" class="form-control disabled" readonly="readonly" required="required" name="" id="" value="{{ $type->key }}" placeholder="Key..."/>
									</td>
									<td>
										<textarea name="" class="form-control" placeholder="Value..." style="word-wrap: break-word; width: 100%;" rows="2" cols="30" id="">{{ $type->name }}</textarea>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</form>
			</div>
</div>
<!-- /.row -->
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		var typeSettingList = $('#typeSettingList').DataTable({
			columns: [
                {
                	"width": "2%",
                    "visible": true, 
                    "searchable": false, 
                    "orderable": false
                },
                {
                	"width": "2%",
                    "visible": true, 
                    "searchable": false, 
                    "orderable": false
                },
                {
                	"width": "20%",
                    "visible": true, 
                    "searchable": true, 
                    "orderable": false
                },
                {
                    "visible": true, 
                    "searchable": true, 
                    "orderable": false
                }
            ],
            sorting: [],
            lengthMenu: [
                [10, 20, 50, -1],
                [ 10, 20, 50, 'Tất cả' ]
            ],
            language: {
                "emptyTable":     "Không có dữ liệu.",
                "info":           "Tổng: _TOTAL_ loại cài đặt.",
                "infoEmpty":      "Tổng: 0 loại cài đặt",
                "infoThousands":  ".",
                "lengthMenu":     "Hiện _MENU_ loại cài đặt",
                "loadingRecords": "Đang tải...",
                "processing":     "Đang xử lý...",
                "search":         "Tìm nhanh:",
                "searchPlaceholder": "Điền từ khóa...",
                "zeroRecords":    "Không tìm thấy loại cài đặt nào thỏa mãn.",
                "paginate": {
                    "sFirst":    "Đầu",
                    "sLast":     "Cuối",
                    "sNext":     "Sau",
                    "sPrevious": "Trước"
                },
                "infoFiltered":   "(Tìm kiếm từ _MAX_ loại cài đặt)"
            },
		});

		typeSettingList.on( 'order.dt search.dt', function () {
	        typeSettingList.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
	            cell.innerHTML = i+1;
	        } );
	    } ).draw();
	} );
</script>
<!-- DataTables -->
<script src="{{  url('public/admin/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
@endsection