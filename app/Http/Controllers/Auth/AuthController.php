<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{

    private static int $count = 5;

    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->back();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user =  User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Người dùng không tồn tại']);
        }
        if (!Hash::check($request->input('password'), $user->password)) {

            $user->increment('login_attempts');
            $user->update(['last_login_attempt' => now()]);
            $user->save();
            if ($user->login_attempts >= self::$count && now()->diffInMinutes($user->last_login_attempt) < 30) {
                return back()->withErrors(['erorr' => 'Tài khoản đã bị khóa 30p']);
            }

            return back()->withErrors(['email' => 'Mật khẩu không chính xác']);
        }
        if ($user->login_attempts >= self::$count && now()->diffInMinutes($user->last_login_attempt) < 30) {
            return back()->withErrors(['erorr' => 'Tài khoản đã bị khóa 30p']);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, true)) {
            $user->update([
                'login_attempts' => 0,
                'last_login_attempt' => null,
            ]);
            return redirect()->intended($user->checkAdmin() ? '/admin' : '/home');
        }
        return back()->withErrors(['error' => "Đăng nhập không thành công"]);
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }


    protected function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        Auth::login($user);

        return redirect('/home');
    }
    protected function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}