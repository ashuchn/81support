<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Static_Content;
use Session;
use Validator;
use Hash;
use DB;

class StaticContentController extends Controller
{
    public function index()
    {
        $data['static_content']=Static_Content::orderby('id','desc')->get();
        return view('admin.static_content.index', $data);
    }
    
    public function create()
    {
        
    }
    
    public function add_static_content()
    {
        
        return view('admin.static_content.add');
    }
      
    public function store(Request $request)
    {
    $validator = Validator::make($request->all(), [
	'type'=>'required',
	'data'=>'required',
	]);

	if($validator->fails()){
	return redirect()->back()
	->withErrors($validator)
	->withInput();
	}

	
	$static_content_data=new Static_Content;
	$static_content_data->type=$request->type;
	$static_content_data->information=$request->data;
	$static_content_data->save();
	$static_content_id = $static_content_data->id;


	\Session::put('success','Data Added Successfully.');
	return redirect()->route('static_content.index');
    }
    
    public function view_static_content($id)
    {
        $data['info'] = Static_Content::find($id);
        return view('admin.static_content.view', $data);
    }
    
    public function show()
    {
        
    }
    
    public function edit()
    {
        
    }
    
    public function update(Request $request)
    {
         $id = $request->static_content_id;
	
	$static_content_data=Static_Content::find($id);
//	$static_content_data->type=$request->type;
	$static_content_data->information=$request->data;
	$static_content_data->save();
	\Session::put('success','Data Updated Successfully.');
	return redirect()->route('admin.view_static_content', ['id' =>$request->static_content_id ]);
    }
    
     public function destroy_static_content($id)
    {
        Static_Content::destroy($id);
		\Session::put('success','Data Deleted Successfully.');
	   return back();
    }
}
