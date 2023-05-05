<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\New_User;
use App\Models\Notification;
use DB;
use Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $data = New_User::all();
        $categories = [
            'new' => "new",
            'hot' => "hot",
            'order' => "order",
            'offer' => "offer",
            'event' => "event",
            'return' => "return",
        ];
        $params = [
            'data' => $data,
            'categories' => $categories
        ];
        
        /**
         * refer to https://php-flasher.io/laravel/
        * flash()->addFlash(
            * string $type, eg.success, info, error, waring
            *string $message, 
            *string $title = null, , eg, data saved etc 
            *array $options = [])
         */
        // flash()->addFlash('success','Data Saved Successfully!!','Data Saved!');
        return view('admin.notification.index', $params);
    }

    public function sendNotification(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'users'   => 'required|array',
            'title' => 'required',
            'message' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ],[
            'users.required' => 'Choose users from dropdown',
            'users.array' => 'Incorrect Format',
            'title.required' => 'Title cannot be empty',
            'message.required' => 'Message cannot be empty',
            'image.required' => 'Image cannot be empty',
            'image.image' => 'Incorrect Format',
        ]);

        if($valid->fails()) {
            return back()->withErrors($valid);
        }

        $input = $request->all();
        $image = $request->image;
        $newFileName = '';
        if ($image) {
            $ext = $image->getClientOriginalExtension();
            $newFileName = time().'.'.$ext;
            $image->move(public_path('notification_images'), $newFileName);
            $input['image'] = $newFileName;
        }

        $users = $request->users;
        foreach ($users as $user) {
            $notification = new Notification();
            $notification->user_id = $user;
            $notification->title = $request->title;
            $notification->description = $request->message;
            $notification->category = $request->category;
            $notification->image = $newFileName;
            $notification->save();
        }

        $data = New_User::all();
        $categories = [
            'new' => "new",
            'hot' => "hot",
        ];
        $params = [
            'data' => $data,
            'categories' => $categories
        ];
        // return view('admin.notification.index', $params)->with('success','Notification sent successfully');
        flash()->addFlash('success','Notification Sent.','Yayy!');
        return redirect()->route('admin.notification');

        // return $request->file('image');
    }
}
