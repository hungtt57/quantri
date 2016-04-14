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
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/extensions/Select/css/select.dataTables.min.css') }}">
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
        <div class="col-lg-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control column_filter" placeholder="Tìm theo tên người dùng" id="col2_filter" data-column="2">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                <input type="text" class="form-control column_filter" placeholder="Tìm theo email người dùng" id="col3_filter" data-column="3">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                <input type="text" class="form-control column_filter" placeholder="Tìm theo role" id="col4_filter" data-column="4">
            </div>
        </div>
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
          <th>Role</th>
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
            <div class="col-lg-4" align="right"><strong>Role</strong>   :</div>
            <div id="user_role" class="col-lg-8" align="left"></div>
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
              <p>Xác nhận xóa (các) người dùng này?</p>
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
          <div class="form-group">
            <label for="">Role</label>:
            <div class="checkbox">
              <label><input type="checkbox" id="{{ $default_role->name }}" value="{{ $default_role->id }}" disabled checked>{{ $default_role->name }}</label>
            </div>
            @foreach($roles as $role)
            <div class="checkbox">
              <label><input type="checkbox" id="{{ $role->name }}" name="role[]" value="{{ $role->id }}">{{ $role->name }}</label>
            </div>
            @endforeach
            <div id="errorUserRole">
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
    // Advanced searching
    function filterColumn ( i ) {
        $('#userList').DataTable().column( i ).search(
            $('#col'+i+'_filter').val()
        ).draw();
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
                    "visible": true, 
                    "searchable": false, 
                    "orderable": false,
                    "className": "select-checkbox center",
                    "defaultContent": " "
                },
                { 
                    "visible": false, 
                    "searchable": false, 
                    "orderable": false,
                    "data": "id" 
                },
                { 
                    "visible": true, 
                    "searchable": true, 
                    "orderable": true,
                    "data": "name" 
                },
                { 
                    "visible": true, 
                    "searchable": true, 
                    "orderable": true,
                    "data": "email" 
                },
                {
                    "visible": true, 
                    "searchable": true, 
                    "orderable": true,
                    "data": function (source, type, val) {
                        var role_str = '<ul>';
                        var roles = source.roles;
                        $.each( roles, function( key, value ) {
                            role_str += '<li>' + value.name + '</li>';
                        });
                        role_str += '</ul>';
                        return role_str;
                    },
                    "defaultContent": ""
                },
                { 
                    "visible": true, 
                    "searchable": false, 
                    "orderable": false,
                    "data": null,
                    "defaultContent": '<button class="btn btn-success open-view-user-modal"><span class="glyphicon glyphicon-eye-open"></span></button> <button class="btn btn-warning open-edit-user-modal"><span class="glyphicon glyphicon-pencil"></span></button> <button class="btn btn-danger open-delete-user-modal"><span class="glyphicon glyphicon-trash"></span></button>'
                }
            ],
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 20, 50, -1],
                [ 'Mặc định', 'Hiện 20 bản ghi', 'Hiện 50 bản ghi', 'Hiện tất cả' ]
            ],
            select: {
                //style:    'os',
                style:    'multi',
                selector: 'td:first-child'
            },
            //Disable automatic sorting on the first column
            sorting: [],
            //order: [[ 0, 'asc' ]],
            language: {
                "emptyTable":     "Không có dữ liệu.",
                "info":           "Tổng: _TOTAL_ người dùng.",
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
                "infoFiltered":   "(Tìm kiếm từ _MAX_ người dùng)",
                select: {
                    rows: "Đã chọn: %d người dùng."
                }
            },
            buttons: [
                {
                    text: 'Thêm người dùng',
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
                            $('#closeErrorUserRole').click();
                        });
                        $('#userCreateEditModal').modal('show');
                    }
                },
                {
                    extend: 'excel',
                    text: 'Xuất tệp Excel',
                    titleAttr: 'Xuất tệp Excel',
                    title: 'Danh sách người dùng',
                    exportOptions: {
                        columns: [2, 3, 4]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Xuất tệp PDF',
                    titleAttr: 'Xuất tệp PDF',
                    title: 'Danh sách người dùng',
                    message: 'Tài liệu chỉ lưu hành nội bộ.',
                    exportOptions: {
                        columns: [2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    text: 'In danh sách',
                    titleAttr: 'In danh sách',
                    title: 'Danh sách người dùng',
                    exportOptions: {
                        columns: [2, 3, 4]
                    }
                },
                {
                    extend: 'pageLength',
                    text: 'Hiện số người dùng trên một trang',
                    titleAttr: 'Hiện số người dùng trên một trang'
                },
                {
                    extend: 'colvis',
                    text: 'Chọn các cột muốn hiển thị',
                    titleAttr: 'Chọn các cột muốn hiển thị',
                    columns: [2, 3, 4]
                },
                {
                    text: 'Khôi phục thứ tự cột mặc định',
                    titleAttr: 'Khôi phục thứ tự cột mặc định',
                    action: function (e) {
                        e.preventDefault();
                        userList.colReorder.reset();
                    }
                },
                {
                    text: 'Tải lại danh sách',
                    titleAttr: 'Tải lại danh sách',
                    action: function (e) {
                        userList.ajax.reload(null, false);
                    }  
                },
                {
                    text: 'Chọn tất cả',
                    titleAttr: 'Chọn tất cả',
                    action: function (e) {
                        userList.rows().select();
                    }
                },
                {
                    text: 'Chọn trang hiện tại',
                    titleAttr: 'Chọn trang hiện tại',
                    action: function (e) {
                        userList.rows().deselect();
                        userList.rows({page: 'current'}).select();
                    }
                },
                {
                    text: 'Bỏ chọn tất cả',
                    titleAttr: 'Bỏ chọn tất cả',
                    action: function (e) {
                        userList.rows().deselect();
                    },
                    enabled: false
                },
                {
                    text: 'Xóa bản ghi đã chọn',
                    titleAttr: 'Xóa bản ghi đã chọn',
                    action: function (e) {
                        ids = '';
                        //Gộp id các bản ghi đã chọn thành 1 chuỗi, mỗi id cách nhau bởi dấu cách
                        userList.rows({selected: true}).data().each(function (group, i) {
                            ids += ' ' + group.id;
                        });
                        deleteUser(ids);
                    },
                    enabled: false
                }
            ],
            colReorder: {
                //fixedColumnsLeft: 1,
                fixedColumnsRight: 1
            }
        });

        //Nếu không có bản ghi nào được chọn thì disable các nút không cần thiết
        function en_dis_button() {
            var selectedRows = userList.rows({selected: true}).count();
            if (selectedRows > 0) {
                userList.button(10).enable();
                userList.button(11).enable();
            } else {
                userList.button(10).disable();
                userList.button(11).disable();
            }
        }

        userList.on('select', function () {
                    en_dis_button();
                })
                .on('deselect', function () {
                    en_dis_button();
                })
                .on('processing.dt', function () {
                    en_dis_button();
                });

        // Advanced searching
        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).attr('data-column') );
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
            $('#closeErrorUserRole').click();
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

                var role_str = '<ul>';
                var roles = data.roles;
                $.each( roles, function( key, role ) {
                    role_str += '<li>' + role.name + '</li>';
                });
                role_str += '</ul>';
                $('#user_role').html(role_str);

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

                var roles = data.roles;
                $.each( roles, function( key, role ) {
                    $('#'+role.name).prop('checked', true);
                });

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
                    $('#closeErrorUserRole').click();
                });
                $('#userCreateEditModal').modal('show');
            })
        } );

        //Create new user/update existing user
        $("#btn-save-user").click(function (e) {
            $('#closeErrorUserName').click();
            $('#closeErrorUserEmail').click();
            $('#closeErrorUserPassword').click();
            $('#closeErrorUserRole').click();

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
                role: $('input:checkbox:checked').map(function () {
                    return this.value;
                }).get()
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
                userList.ajax.reload(null, false);
                $('#userAlert').append('<div class="text-center alert alert-'+data.message_level+'"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+' '+data.flash_message+'</h4></div>');
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
                if (errors.role){
                    $('#errorUserRole').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserRole" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.role+'</div>');
                }
            }
            });
        });

        $('#userList tbody').on('click', '.open-delete-user-modal', function () {
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.id;
            deleteUser(user_id);
        } );

        //Display modal form for deleting user
        function deleteUser(id) {
            $('#userAlert').empty();
            $('#user_id').val(id);
            $('#userDeleteModal').modal('show');
        }

        //Delete user
        $('#btn-delete-user').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            }) 

            var user_ids = $('#user_id').val();

            var formData = {
                ids: user_ids
            }

            $.ajax({
                type: "DELETE",
                url: userUrl + '/destroy',
                data: formData,
                success: function (data) {
                    $('#userDeleteModal').modal('hide');
                    userList.ajax.reload(null, false);
                    $('#userAlert').append('<div id="flash_message" class="text-center alert alert-'+data.message_level+'"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+' '+data.flash_message+'</h4></div>');
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
<script src="{{  url('public/admin/plugins/datatables/extensions/Select/js/dataTables.select.min.js') }}"></script>
@endsection