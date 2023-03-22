<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }
}
