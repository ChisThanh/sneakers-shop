<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        try {
            $data = Socialite::driver($provider)->user();
            $user = User::query()
                ->firstOrCreate([
                    'email' => $data->getEmail(),
                ], [
                    'name' => $data->getName(),
                    'password' => Hash::make($data->getId()),
                ]);

            Auth::login($user, true);
            return redirect("/home");
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}