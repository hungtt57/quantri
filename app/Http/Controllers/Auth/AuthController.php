<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required|email|max:255', 'password' => 'required|min:6|max:60',
        ], [
            $this->loginUsername().'.required' => 'Vui lòng điền địa chỉ email.',
            $this->loginUsername().'.max' => 'Địa chỉ email chỉ dài tối đa 255 kí tự.',
            $this->loginUsername().'.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng điền mật khẩu.',
            'password.min' => 'Mật khẩu phải dài tối thiểu 6 kí tự.',
            'password.max' => 'Mật khẩu chỉ dài tối đa 60 kí tự.'
        ]);

        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function getFailedLoginMessage()
    {
        return "Tài khoản không có trong hệ thống hoặc bạn đã điền sai thông tin.";
    }
}
