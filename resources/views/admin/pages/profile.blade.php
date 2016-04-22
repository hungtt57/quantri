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

	<div class="col-lg-offset-3 col-lg-6">
    @if (Session::has('flash_message'))
        <div id="flash_message" class="text-center alert alert-{!! Session::get('message_level') !!}"><i class="icon fa fa-{!! Session::get('message_icon') !!}"></i> 
        {!! Session::get('flash_message') !!}
        </div>
    @endif
    </div>

    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ route('Not.UserController.profile.update') }}">
      {!! csrf_field() !!}
      <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Tên</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="first_name">Họ (bắt buộc):</label>
	    <div class="col-md-6">
	      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="" value="{{ old('first_name') ? old('first_name') : Auth::user()->first_name  }}">
	      	@if ($errors->has('first_name'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('first_name') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="last_name">Đệm và tên (bắt buộc):</label>
	    <div class="col-md-6">
	      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="" value="{{ old('last_name') ? old('last_name') : Auth::user()->last_name  }}">
	      	@if ($errors->has('last_name'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('last_name') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Thông tin liên hệ</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="email">Địa chỉ email (bắt buộc):</label>
	    <div class="col-md-6">
	      <input type="email" class="form-control" name="email" id="email" placeholder="" value="{{ Auth::user()->email }}" disabled="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="phone">Số điện thoại:</label>
	    <div class="col-md-6">
	      <input type="text" class="form-control" name="phone" id="phone" placeholder="" value="{{ old('phone') ? old('phone') : Auth::user()->phone  }}">
	        @if ($errors->has('phone'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('phone') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="address">Địa chỉ:</label>
	    <div class="col-md-6">
	      <textarea class="form-control" name="address" id="address">{{ old('address') ? old('address') : Auth::user()->address  }}</textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Giới thiệu bản thân</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="bio">Tiểu sử:</label>
	    <div class="col-md-6">
	      <textarea class="form-control" name="bio" id="bio">{{ old('bio') ? old('bio') : Auth::user()->bio  }}</textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="avatar">Ảnh hồ sơ:</label>
	    <div class="col-md-6">
	      <input type="file" class="form-control" name="avatar" id="avatar">
	        @if ($errors->has('avatar'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('avatar') }}</strong>
	        </div>
	        @endif
	       @if(!empty(Auth::user()->avatar))
	       <img style="width: 170px; height: 250px;" src="{{ asset('public/upload/avatar/'.Auth::user()->avatar) }}">
	       <input type="hidden" name="current_avatar" value="{{ Auth::user()->avatar }}">
	       @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Quản lý tài khoản</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="password">Mật khẩu mới:</label>
	    <div class="col-md-6">
	      <input type="password" class="form-control" name="password" id="password" placeholder="">
	        @if ($errors->has('password'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('password') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="password_confirmation">Xác nhận mật khẩu:</label>
	    <div class="col-md-6">
	      <input type="password" name="password_confirmation" class="form-control" id="email" placeholder="">
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

@section('js')
<script>
	$('#flash_message').delay(3000).slideUp();
</script>
@endsection