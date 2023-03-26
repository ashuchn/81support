<?php

namespace App\Http\Controllers\subadmin;
use App\Http\Controllers\Controller;
use App\Models\Riding_Charter_User;
use Validator;
use Session;
use Hash;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $subadmin_id = Session::get('subadminId');
        $subadmin = Riding_Charter_User::where('id', $subadmin_id)->first();
        $params = [
            'subadmin' => $subadmin
        ];
        return view('subadmin.profile.index' , $params);
    }

    public function update(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required'
        ], [
            'required' => ':attribute is required'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $subadmin_id = Session::get('subadminId');
        $subadmin = Riding_Charter_User::where('id', $subadmin_id)->first();

        $subadmin->name = $input['name'];
        $subadmin->mobile = $input['mobile'];

        $subadmin->save();

        return redirect()->route('subadmin.profile.index')->with('success', 'Profile updated successfully');
    }
}
