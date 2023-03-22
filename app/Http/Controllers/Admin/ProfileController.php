<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Session;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user_id = optional(Session::user())->adminId;

        return view('admin.profile.index' , compact('user_id'));
    }
}
