<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Session;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $admin_id = Session::get('adminId');
        $admin_email = Admin::where('id', $admin_id)->first();
        $params = [
            'admin_id' => $admin_id,
            'admin_email' => $admin_email
        ];
        return view('admin.profile.index' , $params);
    }
}
