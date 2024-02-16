<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\LockoutUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{

    private static int $count = 3;

    public function showLoginForm()
    {
        // if (auth()->check()) {
        //     return redirect()->back();
        // }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user =  User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Người dùng không tồn tại']);
        }

        if ($user && $user->login_attempts >= self::$count) {
            $lastAttempt = $user->last_login_attempt;

            if ($lastAttempt && now()->diffInMinutes($lastAttempt) < 30) {
                return back()->withErrors(['email' => 'Tài khoản của bạn đã bị khóa. Vui lòng thử lại sau 30 phút.']);
            } else {
                $user->update([
                    'login_attempts' => 0,
                    'last_login_attempt' => null,
                ]);
            }
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, true)) {

            $user->query()->update([
                'login_attempts' => 0,
                'last_login_attempt' => null,
            ]);

            if ($user->checkAdmin()) {
                return redirect()->intended('/admin');
            }
            return redirect()->intended('/home');
        } else {
            $remaining = self::$count - $user->login_attempts;
            $user->increment('login_attempts');
            $user->query()->update(['last_login_attempt' => now()]);
            return back()->withErrors(['error' => "Thông tin không hợp lệ. Còn lại {$remaining} lần!."]);
        }
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }


    protected function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

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
