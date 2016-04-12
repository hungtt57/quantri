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
<style type="text/css">
	td.details-control {
	    background: url('{{ asset('public/admin/plugins/datatables/images/details_open.png') }}') no-repeat center center;
	    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('{{ asset('public/admin/plugins/datatables/images/details_close.png') }}') no-repeat center center;
	}
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
        <h1 class="page-header">Danh sách người dùng</h1>
    </div>

  <div class="col-lg-12">
    <div class="col-lg-6 col-lg-offset-3" id="userAlert">
            
    </div>
  </div>

  <table class="table table-striped table-bordered table-hover" id="userList">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th>Tên</th>
          <th>Địa chỉ email</th>
          <th>Thao tác</th>
        </tr>
      </thead>
  </table>

  <!-- Modal -->
  <!-- View modal -->
  <div class="modal fade" id="userViewModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Xem người dùng</h4>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="col-lg-4" align="right"><strong>Tên</strong>   :</div>
            <div id="user_name" class="col-lg-8" align="left"></div>
            <br>
            <div class="col-lg-4" align="right"><strong>Email</strong>   :</div>
            <div id="user_email" class="col-lg-8" align="left"></div>
            <br>
            </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>

  <!-- Delete modal -->
  <div class="modal fade" id="userDeleteModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Xóa người dùng</h4>
        </div>
        <form>
        <div class="modal-body">
          <div class="text-center">
              <p>Xác nhận xóa người dùng này?</p>
                <input type="hidden" id="user_id" name="user_id" value="">
            </div>
        </div>
        </form>
        <div class="modal-footer">
          <button class="btn btn-danger" id="btn-delete-user">Xóa</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Create and edit modal -->
  <div class="modal fade" id="userCreateEditModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="userCreateEditModalTitle"></h4>
        </div>
      
      <form id="userCreateEditForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="name">Tên</label>:
            <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="" id="name">
            <div id="errorUserName">
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>:
            <input type="text" value="{{ old('email') }}" name="email" class="form-control" placeholder="" id="email">
            <div id="errorUserEmail">
            </div>
          </div>
          <div class="form-group">
            <label for="password">Mật khẩu</label>:
            <input type="password" value="" name="password" class="form-control" placeholder="" id="password">
            <div id="errorUserPassword">
            </div>
          </div>
        </div>
        </form>
      
      <div class="modal-footer">
        <button id="btn-reset-user" class="btn btn-default">Xóa</button>
          <button class="btn" id="btn-save-user"></button>
          <input type="hidden" id="user_id" name="user_id" value="">
        </div>
      </div>
    </div>
  </div>
  <!-- End modal -->
</div>
@endsection

@section('js')
<script type="text/javascript">
	/* Formatting function for row details - modify as you need */
	function format ( d ) {
	    // `d` is the original data object for the row
	    var role_str = 'Người dùng này thuộc các role:<br><ul>';
	    var roles = d.roles;
	    $.each( roles, function( key, role ) {
		  	role_str += '<li>' + role.name + '</li>';
		});
		role_str += '</ul>';
	    return role_str;
	}

    $(document).ready(function() {
        var baseUrl = $('meta[name="base_url"]').attr('content');

        //l - length changing input control
        //f - filtering input
        //t - The table!
        //i - Table information summary
        //p - pagination control
        //r - processing display element
        var userList = $('#userList').DataTable({
            ajax: baseUrl+"/listUser",
            columns: [
            	{
	                "className":      'details-control',
	                "data":           null,
	                "defaultContent": ''
            	},
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": null }
            ],
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 20, 50, -1],
                [ 'Mặc định', 'Hiện 20 bản ghi', 'Hiện 50 bản ghi', 'Hiện tất cả' ]
            ],
            columnDefs: [
            { "targets": 0, "visible": true, "searchable": false, "orderable": false },
            { "targets": 1, "visible": false, "searchable": true, "orderable": true }, 
            { "targets": 2, "visible": true, "searchable": true, "orderable": true },
            { "targets": 3, "visible": true, "searchable": true, "orderable": true },
            { "targets": 4, "defaultContent": '<button class="btn btn-success open-view-user-modal"><span class="glyphicon glyphicon-eye-open"></span></button> <button class="btn btn-warning open-edit-user-modal"><span class="glyphicon glyphicon-pencil"></span></button> <button class="btn btn-danger open-delete-user-modal"><span class="glyphicon glyphicon-trash"></span></button>', "visible": true, "searchable": false, "orderable": false } 
            ],
            //Disable automatic sorting on the first column
            sorting: [],
            //order: [[ 0, 'asc' ]],
            language: {
                "emptyTable":     "Không có dữ liệu.",
                "info":           "Tổng: _TOTAL_ người dùng",
                "infoEmpty":      "Tổng: 0 người dùng",
                "infoThousands":  ".",
                "lengthMenu":     "Hiện _MENU_ người dùng",
                "loadingRecords": "Đang tải...",
                "processing":     "Đang xử lý...",
                "search":         "Tìm nhanh:",
                "searchPlaceholder": "Điền từ khóa...",
                "zeroRecords":    "Không tìm thấy người dùng nào thỏa mãn.",
                "paginate": {
                    "sFirst":    "Đầu",
                    "sLast":     "Cuối",
                    "sNext":     "Sau",
                    "sPrevious": "Trước"
                },
                "infoFiltered":   "(Tìm kiếm từ _MAX_ người dùng)"
            },
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i>',
                    titleAttr: 'Thêm người dùng',
                    action: function (e) {
                        e.preventDefault();
                        $('#userAlert').empty();
                        $('#btn-save-user').val("add");
                        $('#btn-save-user').addClass('bg-purple');
                        $('#userCreateEditModalTitle').text("Thêm người dùng");
                        $('#btn-reset-user').text("Xóa trắng");
                        $('#btn-save-user').text("Thêm");
                        $('#btn-reset-user').click(function(){
                            $('#userCreateEditModal').find('form')[0].reset();
                            $('#closeErrorUserName').click();
                            $('#closeErrorUserEmail').click();
                            $('#closeErrorUserPassword').click();
                        });
                        $('#userCreateEditModal').modal('show');
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Xuất file Excel',
                    title: 'Danh sách người dùng',
                    exportOptions: {
                        columns: [2, 3]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'Xuất file PDF',
                    title: 'Danh sách người dùng',
                    message: 'Tài liệu chỉ lưu hành nội bộ.',
                    exportOptions: {
                        columns: [2, 3]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'In danh sách',
                    title: 'Danh sách người dùng',
                    exportOptions: {
                        columns: [2, 3]
                    }
                },
                {
                    extend: 'pageLength',
                    text: '<i class="fa fa-minus-square-o"></i>',
                    titleAttr: 'Hiện số người dùng trên một trang'
                },
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-check-square-o"></i>',
                    titleAttr: 'Chọn các cột muốn hiển thị',
                    columns: [2, 3]
                },
                {
                    text: '<i class="fa fa-close"></i>',
                    titleAttr: 'Khôi phục thứ tự cột mặc định',
                    action: function (e) {
                        e.preventDefault();
                        userList.colReorder.reset();
                    }
                },
                {
                    text: '<i class="fa fa-refresh"></i>',
                    titleAttr: 'Tải lại danh sách',
                    action: function (e) {
                        userList.ajax.reload();
                    }  
                }
            ],
            colReorder: {
                //fixedColumnsLeft: 1,
                fixedColumnsRight: 1
            }
        });

		// Add event listener for opening and closing details
	    $('#userList tbody').on('click', 'td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var row = userList.row( tr );
	 
	        if ( row.child.isShown() ) {
	            // This row is already open - close it
	            row.child.hide();
	            tr.removeClass('shown');
	        }
	        else {
	            // Open this row
	            row.child( format(row.data()) ).show();
	            tr.addClass('shown');
	        }
	    } );

        $('input.toggle-article').change(function() {
            var column = userList.column( $(this).attr('value') );
            column.visible( ! column.visible() );
        });

        $('#userCreateEditModal').on('hidden.bs.modal', function(){
            $(this).find('form')[0].reset();
            $('#closeErrorUserName').click();
            $('#closeErrorUserEmail').click();
            $('#closeErrorUserPassword').click();
        });

        var userUrl = baseUrl+"/user";

        //Display modal form for user viewing
        $('#userList tbody').on('click', '.open-view-user-modal', function () {
            $('#userAlert').empty();
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.id;
            $.get(userUrl + '/' + user_id, function (data) {
                $('#user_name').html(data.name);
                $('#user_email').html(data.email);
                $('#userViewModal').modal('show');
            }) 
        } );

        //Display modal form for user editing
        $('#userList tbody').on('click', '.open-edit-user-modal', function () {
            $('#userAlert').empty();
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.id;
            $.get(userUrl + '/' + user_id, function (data) {
                $('#user_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#btn-save-user').val("update");
                $('#btn-save-user').addClass('btn-warning');
                $('#userCreateEditModalTitle').text("Sửa người dùng");
                $('#btn-reset-user').text("Hoàn tác");
                $('#btn-save-user').text("Lưu");
                $('#btn-reset-user').click(function(){
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#password').val('');
                    $('#closeErrorUserName').click();
                    $('#closeErrorUserEmail').click();
                    $('#closeErrorUserPassword').click();
                });
                $('#userCreateEditModal').modal('show');
            })
        } );

        //Create new user/update existing user
        $("#btn-save-user").click(function (e) {
            $('#closeErrorUserName').click();
            $('#closeErrorUserEmail').click();
            $('#closeErrorUserPassword').click();

            formmodified = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            e.preventDefault(); 

            var formData = {
                name: $('#name').val(),
                email: $('#email').val(),
            }

            if($('#password').val()){
            	formData.password = $('#password').val();
            }

            //Used to determine the http verb to use [add=POST], [update=PATCH]
            var state = $('#btn-save-user').val();

            var user_id = $('#user_id').val();

            var type = "POST";
            var my_url = userUrl + '/add';
            
            if (state == "update"){
                type = "PATCH";
               	my_url = userUrl + '/' + user_id;
            }

            $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                $('#userCreateEditModal').modal('hide');
                userList.ajax.reload();
                $('#userAlert').append('<div class="text-center alert alert-'+data.message_level+'"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+data.flash_message+'</h4></div>');
            },
            error: function (data) {
                var errors = data.responseJSON;
                if (errors.name){
                    $('#errorUserName').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserName" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.name+'</div>');
                }
                if (errors.email){
                    $('#errorUserEmail').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserEmail" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.email+'</div>');
                }
                if (errors.password){
                    $('#errorUserPassword').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserPassword" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.password+'</div>');
                }
            }
            });
        });

        //Display modal form for deleting user
        $('#userList tbody').on('click', '.open-delete-user-modal', function () {
            $('#userAlert').empty();
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.id;
            $('#user_id').val(user_id);
            $('#userDeleteModal').modal('show');
        } );

        //Delete user
        $('#btn-delete-user').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            }) 

            var user_id = $('#user_id').val();
            $.ajax({
                type: "DELETE",
                url: userUrl + '/destroy/' + user_id,
                success: function (data) {
                    $('#userDeleteModal').modal('hide');
                    userList.ajax.reload();
                    $('#userAlert').append('<div id="flash_message" class="text-center alert alert-'+data.message_level+'"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+data.flash_message+'</h4></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });
</script>
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