<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        return view('admin.users.index');
    }

    public function getPaginate(Request $request)
    {
        $page = $request->input('page', 1);
        $users = User::query()->paginate(5);
        if ($page > $users->lastPage()) {
            return redirect()->route('api.user.index', ['page' =>  $users->lastPage()]);
        }
        return $users;
    }
}