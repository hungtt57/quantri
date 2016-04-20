@extends('admin.layout.master')

@section('title')
Cài đặt chung
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Cài đặt chung</h1>
    </div>
    <!-- /.col-lg-12 -->

	<div class="col-lg-12">
	    <div class="col-lg-offset-3 col-lg-6">
	    @if (Session::has('flash_message'))
	        <div id="flash_message" class="text-center alert alert-{!! Session::get('message_level') !!}"><i class="icon fa fa-{!! Session::get('message_icon') !!}"></i> 
	        {!! Session::get('flash_message') !!}
	        </div>
	    @endif
	    </div>
    </div>

    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ route('HomeController.setting.general.update') }}">
      {!! csrf_field() !!}
	  <div class="form-group">
	    <label class="control-label col-md-3" for="email">Địa chỉ email:</label>
	    <div class="col-md-6">
	      <input type="email" class="form-control" id="email" placeholder="" value="">
	      <p><i>Địa chỉ này chỉ sử dụng cho mục đích quản trị, chẳng hạn để gửi mail kích hoạt đăng ký, gửi thông báo đến thành viên...</i></p>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="active_register">Mở/khóa đăng ký:</label>
	    <div class="col-md-6">
	      <input type="checkbox" id="active_register" name="active_register">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="default_role">Vai trò khi mới đăng ký:</label>
	    <div class="col-md-6">
	      <select class="form-control" id="default_role" name="default_role">
		    <?php role_select($roles, old('default_role')); ?>
		  </select>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="logo">Logo trang:</label>
	    <div class="col-md-6">
	      <input type="file" class="form-control" id="logo" name="logo">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="timezone">Múi giờ:</label>
	    <div class="col-md-6">
	      <select class="form-control" id="timezone" name="timezone">
		    
		  </select>
		  <p><i>Hãy chọn thành phố có cùng múi giờ với bạn.</i></p>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="date_format">Định dạng ngày:</label>
	    <div class="col-md-6">
	        <div class="date_format">
			  <input type="radio" name="date_format" checked="true"> Y-m-d
			</div>
			<div class="date_format">
			  <input type="radio" name="date_format"> m/d/Y
			</div>
			<div class="date_format">
			  <input type="radio" name="date_format"> d/m/Y
			</div>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="time_format">Định dạng thời gian:</label>
	    <div class="col-md-6">
	        <div class="time_format">
			  <input type="radio" name="time_format" checked="true"> g:i a
			</div>
			<div class="time_format">
			  <input type="radio" name="time_format"> g:i A
			</div>
			<div class="time_format">
			  <input type="radio" name="time_format"> H:i
			</div>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="start_of_week">Ngày đầu tuần:</label>
	    <div class="col-md-6">
	      <select class="form-control" id="start_of_week" name="start_of_week">
		    
		  </select>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="language">Ngôn ngữ của trang:</label>
	    <div class="col-md-6">
	      <select class="form-control" id="language" name="language">
		    <option value="vi">Tiếng Việt</option>
		    <option value="en">Tiếng Anh</option>
		  </select>
	    </div>
	  </div>
	  <div class="form-group"> 
	    <div class="col-md-offset-5 col-md-4">
	      <button type="submit" class="btn btn-primary btn-lg">Lưu thay đổi</button>
	    </div>
	  </div>
	</form>
</div>
<!-- /.row -->
@endsection

@section('js')
<script>
	$('#flash_message').delay(3000).slideUp();
</script>
@endsection