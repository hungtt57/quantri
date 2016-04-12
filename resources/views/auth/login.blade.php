@extends('layouts.app')
@section('title')
Đăng nhập
@endsection
@section('content')
<div class="pen-title">
    <h1>Trang BACKEND</h1>
  
</div>

<div class="module form-module">
    <div class="toggle"><i class="fa fa-arrow-left fa-arrow-right"></i>
        <div class="tooltiptext">Quên mật khẩu</div>
    </div>

    <div class="form">
        <h2>Đăng nhập</h2>
        <form method="post" action="{{ url('/login') }}">
          <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
          <input type="text" name="email" value="{{ old('email') }}" placeholder="Địa chỉ email..."/>
          @if ($errors->has('email'))
          <div class="alert alert-danger">
            <strong>{{ $errors->first('email') }}</strong>
          </div>
          @endif
          <input type="password" name="password" placeholder="Mật khẩu..."/>
          @if ($errors->has('password'))
          <div class="alert alert-danger">
            <strong>{{ $errors->first('password') }}</strong>
          </div>
          @endif
          <button type="submit">Tiếp tục</button>
        </form>
    </div>

    <div class="form">
        <h2>Thiết lập lại mật khẩu</h2>
        <form>
          <input type="email" placeholder="Địa chỉ email..."/>
          <button>Nhận email</button>
        </form>
    </div>

    <div class="cta"><a href="#">Về trang FRONTEND</a>
    </div>
</div>
@endsection