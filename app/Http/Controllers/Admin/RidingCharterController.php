<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riding_Charter_User;
use Session;
use Validator;
use Hash;
use DB;

class RidingCharterController extends Controller
{
    public function index()
    {
        $data['ridingcharter']=Riding_Charter_User::orderby('id','desc')->get();
        return view('admin.ridingcharter.index', $data);
    }
    
    public function create()
    {
        
    }
    
    public function add_ridingcharter()
    {
        
        return view('admin.ridingcharter.add');
    }
      
    public function store(Request $request)
    {
    $validator = Validator::make($request->all(), [
	'name'=>'required|max:100|min:0',
	'mobile'=>'required|max:10|min:0|unique:riding_charter_users',
	'email' => 'required|email|max:100|min:0|unique:riding_charter_users',
	'password' => 'required|max:100|min:0',
	'file' => 'mimes:jpg,jpeg,png,svg|max:2048',
	]);

	if($validator->fails()){
	return redirect()->back()
	->withErrors($validator)
	->withInput();
	}

	
	
	
	$length = 50;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
	$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	$randomString;
	
	
	$riding_charter_profile=new Riding_Charter_User;
	
	
	if($request->file('file')){
	$imageName = time().'.'.$request->file->extension();
	$request->file->move(public_path('uploads/riding_charter_user'),$imageName);
	$riding_charter_profile->image=url('public/uploads/riding_charter_user').'/'.$imageName;
	}else{
	$riding_charter_profile->image=url('public/uploads/riding_charter_user/dummy.jpeg'); 
	} 
 
 
	$riding_charter_profile->name           =  $request->name;
	$riding_charter_profile->remember_token = $randomString;
	$riding_charter_profile->email          = $request->email;
	$riding_charter_profile->mobile         = $request->mobile;
	$riding_charter_profile->password       = Hash::make($request->password);
	$riding_charter_profile->latitude       = $request->latitude;
	$riding_charter_profile->longitude      = $request->longitude;
	$riding_charter_profile->status         = '0';
	$riding_charter_profile->save();
	$user_id = $riding_charter_profile->id;


	\Session::put('success','Data Added Successfully.');
	return redirect()->route('ridingcharter.index');
    }
    
    public function change_status_ridingcharter(Request $request)
	{
		$status = $request->status;
		$id = $request->id;
		$usr = Riding_Charter_User::find($id);
		$res = $usr->status;
		if($res == 0){
			$usr->status = 1;
			$usr->save();
		}else{
			$usr->status = 0;
			$usr->save();
		}
		return response()->json(['success'=>'Status change successfully','status'=>$status,'id'=>$id]);
	}
    
    public function view_ridingcharter($id)
    {
        $data['info'] = Riding_Charter_User::find($id);
        return view('admin.ridingcharter.view', $data);
    }
    
    public function show()
    {
        
    }
    
    public function edit()
    {
        
    }
    
    public function update(Request $request)
    {
         $id = $request->riding_charter_id;
	
	$riding_charter_profile=Riding_Charter_User::find($id);
	$riding_charter_profile->name=$request->name;
	$riding_charter_profile->email=$request->email;
	$riding_charter_profile->mobile=$request->mobile;
	$riding_charter_profile->save();
	\Session::put('success','Data Updated Successfully.');
	return redirect()->route('admin.view_ridingcharter', ['id' =>$request->riding_charter_id ]);
    }
    
    public function destroy_ridingcharter($id)
    {
        Riding_Charter_User::destroy($id);
		\Session::put('success','Data Deleted Successfully.');
	   return back();
    }
}
