<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Riding_Charter_User;
use Validator;
use DB;

class ProductController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::orderBy('created_at','desc')->paginate(5);
        //for appending server url to public url
        foreach($data as $rows) {
            // return $new;
            $images = DB::table('product_images')->where('productId', $rows->id)->get('image')->toArray();
            $new = array();
            foreach($images as $image) {
                $url = url('/').'/'.$image->image;
                array_push($new, $url);
            }
            $rows->images = $new;
        }
        // return $data;
        return view('admin.product.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $users = Riding_Charter_User::get(['id','name']);
        // return $users;
        return view('admin.product.create', compact('category', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'rc_id'         => 'required',
            'productName'   => 'required',
            'price'         => 'required',
            'description'   => 'required',
            // 'images'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            'rc_id'                => 'Select Riding Charter',
            'productName.required' => 'Category name cannot be Empty',
            'price.required'       => 'Price name cannot be Empty',
            'description.required' => 'Description cannot be Empty',
            // 'images.format' => 'Incorrect Image format',
            // 'images.max' => 'Image size limit Exceeded',
        ]);
        if($valid->fails()) {
            return back()->withErrors($valid);
        }

        $insert = new Product;
        $insert->categoryId = $request->category;
        $insert->productName = $request->productName;
        $insert->price = $request->price;
        $insert->description = $request->description;
        $insert->available_quantity = $request->available_quantity;
        $insert->rc_id = $request->rc_id;
        if($insert->save()) {
            if ($request->has('images')) {
                foreach ($request->images as $key => $file) {
                    $name = time() . $key . '.' . $file->extension();
                    // $dest_path='public/Place_upload';
                    $file->move(public_path('product_images'), $name);
                    DB::table('product_images')->insert([
                        'productId' => $insert->id,
                        'image' => 'public/product_images/'.$name
                    ]);
                }
            } 
            return redirect()->route('product.index')->with('success','Product Added');
        } else {
            return redirect()->route('product.index')->with('success','Oops! Some error Occured');
        }

        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
