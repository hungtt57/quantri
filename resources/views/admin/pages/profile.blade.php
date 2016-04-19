@extends('admin.layout.master')

@section('title')
Hồ sơ của bạn
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Hồ sơ của bạn</h1>
    </div>
    <!-- /.col-lg-12 -->

    <form class="form-horizontal" role="form" enctype="multipart/form-data">
      <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Tên</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="first_name">Họ:</label>
	    <div class="col-md-6">
	      <input type="text" class="form-control" id="first_name" placeholder="">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="last_name">Đệm và tên:</label>
	    <div class="col-md-6">
	      <input type="text" class="form-control" id="last_name" placeholder="">
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Thông tin liên hệ</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="email">Địa chỉ email:</label>
	    <div class="col-md-6">
	      <input type="email" class="form-control" id="email" placeholder="" value="{{ Auth::user()->email }}" disabled="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="phone">Số điện thoại:</label>
	    <div class="col-md-6">
	      <input type="text" class="form-control" id="phone" placeholder="">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="address">Địa chỉ:</label>
	    <div class="col-md-6">
	      <textarea class="form-control" id="address"></textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Giới thiệu bản thân</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="bio">Tiểu sử:</label>
	    <div class="col-md-6">
	      <textarea class="form-control" id="bio"></textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="avatar">Ảnh hồ sơ:</label>
	    <div class="col-md-6">
	      <input type="file" class="form-control" id="avatar">
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Quản lý tài khoản</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="password">Mật khẩu mới:</label>
	    <div class="col-md-6">
	      <input type="password" class="form-control" id="password" placeholder="">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="password_confirmation">Xác nhận mật khẩu:</label>
	    <div class="col-md-6">
	      <input type="password_confirmation" class="form-control" id="email" placeholder="">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="session">Phiên đăng nhập:</label>
	    <div class="col-md-6">
	      <button class="btn btn-default" disabled="true">Đăng xuất khỏi những nơi khác</button>
	      <p><i>Bạn mới đăng nhập ở một nơi.</i></p>
	    </div>
	  </div>
	  <div class="form-group"> 
	    <div class="col-md-offset-5 col-md-4">
	      <button type="submit" class="btn btn-primary btn-lg">Cập nhật hồ sơ</button>
	    </div>
	  </div>
	</form>
</div>
<!-- /.row -->
@endsection