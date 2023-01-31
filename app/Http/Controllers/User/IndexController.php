<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
       // return view('user.index');
    }

    public function index() {
        $user = User::find(auth()->user()->id);
        $admin = false;

        foreach ($user->roles as $role) {
            if (($role->id == 1) || ($role->id == 2))
                $admin = true;
        }

        return view('user.index', compact('admin'));
    }
}
