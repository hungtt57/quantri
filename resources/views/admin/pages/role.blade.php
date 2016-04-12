@extends('admin.layout.master')

@section('title')
Quản lý phân quyền
@stop

@section('css')
<style type="text/css">
    /*  bhoechie tab */
    div.bhoechie-tab-container{
      z-index: 10;
      background-color: #ffffff;
      padding: 0 !important;
      border-radius: 4px;
      -moz-border-radius: 4px;
      border:1px solid #ddd;
      margin-top: 20px;
      margin-left: 50px;
      -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
      box-shadow: 0 6px 12px rgba(0,0,0,.175);
      -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
      background-clip: padding-box;
      opacity: 0.97;
      filter: alpha(opacity=97);
  }
  div.bhoechie-tab-menu{
      padding-right: 0;
      padding-left: 0;
      padding-bottom: 0;
  }
  div.bhoechie-tab-menu div.list-group{
      margin-bottom: 0;
  }
  div.bhoechie-tab-menu div.list-group>a{
      margin-bottom: 0;
  }
  div.bhoechie-tab-menu div.list-group>a .glyphicon,
  div.bhoechie-tab-menu div.list-group>a .fa {
      color: #5A55A3;
  }
  div.bhoechie-tab-menu div.list-group>a:first-child{
      border-top-right-radius: 0;
      -moz-border-top-right-radius: 0;
  }
  div.bhoechie-tab-menu div.list-group>a:last-child{
      border-bottom-right-radius: 0;
      -moz-border-bottom-right-radius: 0;
  }
  div.bhoechie-tab-menu div.list-group>a.active,
  div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
  div.bhoechie-tab-menu div.list-group>a.active .fa{
      background-color: #5A55A3;
      background-image: #5A55A3;
      color: #ffffff;
  }
  div.bhoechie-tab-menu div.list-group>a.active:after{
      content: '';
      position: absolute;
      left: 100%;
      top: 50%;
      margin-top: -13px;
      border-left: 0;
      border-bottom: 13px solid transparent;
      border-top: 13px solid transparent;
      border-left: 10px solid #5A55A3;
  }

  div.bhoechie-tab-content{
      background-color: #ffffff;
      /* border: 1px solid #eeeeee; */
      padding-left: 20px;
      padding-top: 10px;
  }

  div.bhoechie-tab div.bhoechie-tab-content:not(.active){
      display: none;
  }
</style>
<link rel="stylesheet" href="{{asset('public/admin/jqwidgets/styles/jqx.base.css')}}" type="text/css" />
@endsection

@section('content')

    
<div class="row">
    <div class="col-lg-12">
      <div class="col-lg-6 col-lg-offset-3" id="roleAlert">
              
      </div>
    </div>

    <div class="cotaniner" style="margin-top: 20px;
        margin-left: 50px;">
        <button class="btn btn-primary open-add-role-modal">Thêm role mới</button>
        <a href="{{asset('synchronous')}}"><button class="btn btn-primary ">Đồng bộ quyền</button></a>
           <!--   @if (Session::has('dongbo'))
            <div class="alert alert-success">
                {{ Session::get('dongbo') }}
            </div> 
          @endif    --> 
    </div>


    <!-- Add role modal -->
    <div class="modal fade" id="roleAddModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="roleAddModalTitle">Thêm role</h4>
          </div>
        
          <form id="roleAddForm">
          <div class="modal-body">
              <div class="form-group">
                <label for="name">Tên role</label>:
                <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="" id="name">
                <div id="errorRoleName">
                </div>
              </div>
          </div>
          </form>
        
          <div class="modal-footer">
            <button id="btn-reset-role" class="btn btn-default">Xóa trắng</button>
            <button class="btn" id="btn-add-role">Thêm</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End modal -->

    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 bhoechie-tab-container">
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
          <div class="list-group">
          @foreach ($roles as $role)
          <a href="#" class="list-group-item text-center">
              <h4 class="fa fa-user"></h4><br/>{{ $role->name }}
          </a>
          @endforeach
          </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
        @foreach ($roles as $role)
        <div class="bhoechie-tab-content">
          <div class="col-sm-8">
            <div id='jqxTree' class="jqxTree">
              <ul>
                <li item-expanded='true' ><a href="#">Tất cả</a>
                  <ul>
                  @foreach($permissions as $permission)
                    @if ($permission_childs = DB::table('permissions')->where('parent_id','=',$permission->id)->get())
                    <li><a href="#">{{$permission->label}}</a>
                      <ul>
                        @foreach($permission_childs as $permission_child)
                        <li><a href="#">{{$permission_child->label}}</a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endif
                  @endforeach    
                  </ul>
                </li>                       
              </ul>
            </div>
          </div>
          <div class="col-sm-4"> 
            <div class="sidebar-search">
              <div class="input-group custom-search-form">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
        @endforeach              
      </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
          e.preventDefault();
          $(this).siblings('a.active').removeClass("active");
          $(this).addClass("active");
          var index = $(this).index();
          $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
          $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });

        $('#roleAddModal').on('hidden.bs.modal', function(){
            $(this).find('form')[0].reset();
            $('#closeErrorRoleName').click();
        });

        $('.open-add-role-modal').on('click', function () {
          $('#roleAlert').empty();
          $('#btn-reset-role').click(function(){
              $('#roleAddModal').find('form')[0].reset();
              $('#closeErrorRoleName').click();
          });
          $('#roleAddModal').modal('show');
        });

        var baseUrl = $('meta[name="base_url"]').attr('content');
        var roleUrl = baseUrl+"/role";

        //Create new role
        $("#btn-add-role").click(function (e) {
            $('#closeErrorRoleName').click();

            formmodified = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            e.preventDefault(); 

            var formData = {
                name: $('#name').val(),
            }

            var type = "POST";
            var add_role_url = roleUrl + '/add';

            $.ajax({
              type: type,
              url: add_role_url,
              data: formData,
              dataType: 'json',
              success: function (data) {
                  $('#roleAddModal').modal('hide');
                  $('#roleAlert').append('<div class="text-center alert alert-'+data.message_level+'"><button id="closeRoleAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+data.flash_message+'</h4></div>');
            },
            error: function (data) {
                var errors = data.responseJSON;
                if (errors.name){
                    $('#errorRoleName').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorRoleName" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.name+'</div>');
                }
            }
            });
        });
    });
</script>

<script type="text/javascript" src="{{asset('public/admin/jqwidgets/jqxcore.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin/jqwidgets/jqxbuttons.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin/jqwidgets/jqxscrollbar.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin/jqwidgets/jqxpanel.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin/jqwidgets/jqxtree.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin/jqwidgets/jqxcheckbox.js')}}"></script>
<script type="text/javascript">
    $('.jqxTree').jqxTree({ height: 'auto', width: 'auto', hasThreeStates: true, checkboxes: true});
</script>
<script type="text/javascript">
  $(".list-group-item:first-child").addClass("active");
  $(".bhoechie-tab-content:first-child").addClass("active");
</script>
@endsection