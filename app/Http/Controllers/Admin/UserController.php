<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\New_User;
use Session;
use Validator;
use Hash;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $data["user"] = New_User::orderby("id", "desc")->get();
        return view("admin.user.index", $data);
    }

    public function create()
    {
    }

    public function add_user()
    {
        return view("admin.user.add");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|max:100|min:0",
            "mobile" => "required|max:10|min:10|unique:new_users",
            "email" => "required|email|max:100|min:0|unique:new_users",
            "password" => "required|max:50|min:8",
            "file" => "mimes:jpg,jpeg,png,svg|max:2048",
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $length = 50;
        $characters =
            "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charactersLength = strlen($characters);
        $randomString = "";
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString;

        $userprofile = new New_User();

        if ($request->file("file")) {
            $imageName = time() . "." . $request->file->extension();
            $request->file->move(public_path("uploads/new_user"), $imageName);
            $userprofile->image =
                url("public/uploads/new_user") . "/" . $imageName;
        } else {
            $userprofile->image = url("public/uploads/new_user/dummy.jpeg");
        }

        $userprofile->name = $request->name;
        $userprofile->remember_token = $randomString;
        $userprofile->email = $request->email;
        $userprofile->mobile = $request->mobile;
        $userprofile->password = Hash::make($request->password);
        //$userprofile->password= $request->password;
        $userprofile->save();
        $user_id = $userprofile->id;

        \Session::put("success", "Data Added Successfully.");
        return redirect()->route("user.index");
    }

    public function change_status_user(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        $usr = New_User::find($id);
        $res = $usr->status;
        if ($res == 0) {
            $usr->status = 1;
            $usr->save();
        } else {
            $usr->status = 0;
            $usr->save();
        }

        return response()->json([
            "success" => "Status change successfully",
            "status" => $usr->status,
            "id" => $id,
        ]);
    }

    public function view_user($id)
    {
        $data["info"] = New_User::find($id);
        return view("admin.user.view", $data);
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function update(Request $request)
    {
        $id = $request->user_id;

        $userprofile = New_User::find($id);
        $userprofile->name = $request->name;
        $userprofile->email = $request->email;
        $userprofile->mobile = $request->mobile;
        $userprofile->save();
        \Session::put("success", "Data Updated Successfully.");
        return redirect()->route("admin.view_user", [
            "id" => $request->user_id,
        ]);
    }

    public function destroy_user($id)
    {
        New_User::destroy($id);
        \Session::put("success", "Data Deleted Successfully.");
        return back();
    }
}
