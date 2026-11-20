<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Users\ListUsersAction;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, ListUsersAction $listUsers): View
    {
        return view('admin.users.index', $listUsers->handle($request));
    }
}
