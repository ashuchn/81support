<?php

namespace App\Http\Controllers\subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; 
use Validator;
use DB;
use Session;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $data = Product::where('rc_id', session()->get('subadminId'))
                ->join('categories', 'categories.id','=','products.categoryId')
                ->orderBy('created_at','desc')
                ->select(['products.*','categories.categoryName'])->paginate(5);

        $products = $data->map(function($product){
            $images = DB::table('product_images')->where('productId', $product->id)->pluck('image');
            // return $images;
            $product->images = $images;
            return $product;
        });

        $params = [
            'categories' => $categories,
            'data' => $data
        ];
        
        return view('subadmin.products.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('subadmin.products.create', compact('category'));
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
            // 'rc_id'         => 'required',
            'productName'   => 'required',
            'price'         => 'required',
            'description'   => 'required',
            // 'images'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            // 'rc_id'                => 'Select Riding Charter',
            'productName.required' => 'Category name cannot be Empty',
            'price.required'       => 'Price name cannot be Empty',
            'description.required' => 'Description cannot be Empty',
            // 'images.format' => 'Incorrect Image format',
            // 'images.max' => 'Image size limit Exceeded',
        ]);
        if($valid->fails()) {
            return back()->withErrors($valid);
        }

        return $request->all();





        // $insert = new Product;
        // $insert->categoryId = $request->category;
        // $insert->productName = $request->productName;
        // $insert->price = $request->price;
        // $insert->description = $request->description;
        // $insert->available_quantity = $request->available_quantity;
        // $insert->rc_id = session()->get('subadminId');
        // if($insert->save()) {
        //     if ($request->has('images')) {
        //         foreach ($request->images as $key => $file) {
        //             $name = time() . $key . '.' . $file->extension();
        //             // $dest_path='public/Place_upload';
        //             $file->move(public_path('product_images'), $name);
        //             DB::table('product_images')->insert([
        //                 'productId' => $insert->id,
        //                 'image' => 'public/product_images/'.$name
        //             ]);
        //         }
        //     } 
        //     return redirect()->route('subadmin.products.index')->with('success','Product Added');
        // } else {
        //     return redirect()->route('subadmin.products.index')->with('success','Oops! Some error Occured');
        // }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::all();
        $product = Product::find($id);
        $productImages = DB::table('product_images')->where('productId', $id)->pluck('image');
        // return $product;
        
        return view('subadmin.products.view', compact('product','productImages','category'));
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
        return $request;
        $valid = Validator::make($request->all(),[
            // 'rc_id'         => 'required',
            'productName'   => 'required',
            'price'         => 'required',
            'description'   => 'required',
            // 'images'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            // 'rc_id'                => 'Select Riding Charter',
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
        // $insert->rc_id = session()->get('subadminId');
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
            return redirect()->route('subadmin.products.index')->with('success','Product Added');
        } else {
            return redirect()->route('subadmin.products.index')->with('success','Oops! Some error Occured');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
		\Session::put('success','Product Deleted Successfully.');
	   return back();
    }
}
