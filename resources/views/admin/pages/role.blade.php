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

   /*tree*/
  .acidjs-css3-treeview,
.acidjs-css3-treeview *
{
    padding: 0;
    margin: 0;
    list-style: none;
}
 
.acidjs-css3-treeview label[for]::before,
.acidjs-css3-treeview label span::before
{
    content: "\25b6";
    display: inline-block;
    margin: 2px 0 0;
    width: 13px;
    height: 13px;
    vertical-align: top;
    text-align: center;
    color: white;
    font-size: 8px;
    line-height: 13px;
}
 
.acidjs-css3-treeview li ul
{
    margin: 0 0 0 22px;
}
 
.acidjs-css3-treeview *
{
    vertical-align: middle;
}
 
.acidjs-css3-treeview
{
    font-size: 14px;
    border: 1px solid #f2f2f2;
    max-height:360px; 
    max-width:350px; 
    padding:20px; 
    background:#fff; 
    border-radius:3px; 
    box-shadow:2px 2px 3px rgba(0,0,0,.1);
}
 
.acidjs-css3-treeview li
{
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
}
 
.acidjs-css3-treeview input[type="checkbox"]
{
    display: none;
}
 
.acidjs-css3-treeview label
{
    cursor: pointer;
}
 
.acidjs-css3-treeview label[for]::before
{
    -webkit-transform: translatex(-24px);
    -moz-transform: translatex(-24px);
    -ms-transform: translatex(-24px);
    -o-transform: translatex(-24px);
    transform: translatex(-24px);
}
 
.acidjs-css3-treeview label span::before
{
    -webkit-transform: translatex(16px);
    -moz-transform: translatex(16px);
    -ms-transform: translatex(16px);
    -o-transform: translatex(16px);
    transform: translatex(16px);
}
 
/*.acidjs-css3-treeview input[type="checkbox"][id]:checked ~ label[for]::before
{
    content: "\25bc";
}*/
 
.acidjs-css3-treeview input[type="checkbox"][id]:not(:checked) ~ ul
{
    display: none;
}
 
.acidjs-css3-treeview label:not([for])
{
    margin: 0 8px 0 0;
}
 
.acidjs-css3-treeview label span::before
{
    content: "";
    border: solid 1px #1375b3;
    color: #1375b3;
    opacity: .50;
}
 
.acidjs-css3-treeview label input:checked + span::before
{
    content: "\2714";
    box-shadow: 0 0 2px rgba(0, 0, 0, .25) inset;
    opacity: 1;
}

</style>
<!-- custom scrollbar CSS -->
<link rel="stylesheet" href="http://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css">


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
         @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
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
            <div class="acidjs-css3-treeview">
    <ul>
        <li>
            <label><input type="checkbox" /><span></span></label><label for="node-0">Tất cả</label>
            <ul>
             @foreach($permissions as $permission)
                    @if ($permission_childs = DB::table('permissions')->where('parent_id','=',$permission->id)->get())
                <li>
                   <label><input type="checkbox" id = '{{$permission->id}}'/><span></span></label><label for="node-0-0">{{$permission->label}}</label>
                    <ul>
                     @foreach($permission_childs as $permission_child)
                        <li>
                            <label><input type = "checkbox" id = '{{$permission_child->id}}'/><span></span></label><label for="node-0-0-0">{{$permission_child->label}}</label>
                        </li>
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
<script type="text/javascript">
  $(".list-group-item:first-child").addClass("active");
  $(".bhoechie-tab-content:first-child").addClass("active");
</script>
<!-- tree checkbox -->
<script type="text/javascript">
  $(".acidjs-css3-treeview").delegate("label input:checkbox", "change", function() {
    var
        checkbox = $(this),
        nestedList = checkbox.parent().next().next(),
        selectNestedListCheckbox = nestedList.find("label:not([for]) input:checkbox");
 
    if(checkbox.is(":checked")) {
        return selectNestedListCheckbox.prop("checked", true);
    }
    selectNestedListCheckbox.prop("checked", false);
});
</script>
<script src="http://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
  (function($){
    $(window).load(function(){
      /* initialize scrollbar */
      $(".acidjs-css3-treeview").mCustomScrollbar({
        mouseWheelPixels: 80,
        theme:"dark-3",
        scrollButtons:{enable:true}
      });
      /* insert twitter widget js in window load fn */
      !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
    });
  })(jQuery);
</script>
@endsection