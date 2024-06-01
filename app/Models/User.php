<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'email',
        'phone',
        'address',
        'password',
        'role',
        'phone',
        'address',
        'firtsname',
        'lastname',
        'login_attempts',
        'last_login_attempt'
    ];

    public function checkAdmin(): bool
    {
        return $this->role === UserRoleEnum::ADMIN;
    }
}