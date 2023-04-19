<?php

namespace App\Http\Controllers\subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSizeQuantity;
use App\Models\ProductImages;
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
        $colors = DB::table('colors')->get();
        return view('subadmin.products.create', compact('category', 'colors'));
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

        // return $request->all();

        $product = new Product;
        $product_images = new ProductImages;

        $product->rc_id = session()->get('subadminId');
        $product->productName = $request->productName;
        $product->price = $request->price;
        $product->categoryId = $request->category;
        $product->description = $request->description;
        $product->available_quantity = array_sum($request->quantity);
        $product->save();

        $totalColors = count($request->colors);
        $totalQty = count($request->quantity);

        $psq = [];

        for($i=0; $i<$totalColors; $i++) {
            for($j=0; $j<$totalQty/$totalColors; $j++) {
                $product_size_quantity = new ProductSizeQuantity;
                $product_size_quantity->product_id = $product->id;
                $product_size_quantity->color = $request->colors[$i];
                $product_size_quantity->size = $request->sizes[$j];
                $product_size_quantity->quantity = $request->quantity[$i*$totalQty/$totalColors+$j];
                $product_size_quantity->save();
                $psq[$i][$j] = $product_size_quantity;
            }
        }

        // if ($request->has('images')) {
        //     for($i=0; $i<$totalColors; $i++) {
        //         foreach ($request->images as $key => $file) {
        //             $name = time() . $key . '.' . $file->extension();
        //             // $dest_path='public/Place_upload';
        //             $file->move(public_path('product_images'), $name);
        //             DB::table('product_images')->insert([
        //                 'productId' => $product->id,
        //                 'image' => 'public/product_images/'.$name,
        //                 'color' => $request->colors[$i]
        //             ]);
        //         }
        //     }
        // }

        // return compact('product', 'psq');

        return redirect()->route('subadmin.products.index')->with('success','Product Added');
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

        $totalColors = ProductSizeQuantity::where('product_id', $id)->distinct('color')->count('color');
        $totalQty = ProductSizeQuantity::where('product_id', $id)->count('color');
        $colors = ProductSizeQuantity::where('product_id', $id)->select('color')->groupBy('color')->get();
        $sizes = ProductSizeQuantity::where('product_id', $id)->select('size')->groupBy('size')->get();

        for($i=0; $i<$totalColors; $i++) {
            for($j=0; $j<$totalQty/$totalColors; $j++) {
                $rows[$i][$j] = ProductSizeQuantity::where('product_id', $id)->where('color', $colors[$i]->color)->where('size', $sizes[$j]->size)->first();
            }
        }

        $sizeTable = DB::table('sizes')->get();

        // return compact('rows');

        return view('subadmin.products.view', compact('product', 'productImages', 'category', 'colors', 'rows'));
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
        // return $request;
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
            return 'back()->withErrors($valid)';
        }

        $product = Product::find($id);
        // $product_images = new ProductImages;

        $product->productName = $request->productName;
        $product->price = $request->price;
        $product->categoryId = $request->category;
        $product->description = $request->description;
        $product->available_quantity = array_sum($request->quantity);
        $product->save();

        return 'level 1';

        $totalColors = count($request->colors);
        $totalQty = count($request->quantity);

        for($i=0; $i<$totalColors; $i++) {
            for($j=0; $j<$totalQty/$totalColors; $j++) {
                $product_size_quantity = ProductSizeQuantity::where('product_id', $id)->where('color', $request->colors[$i])->where('size', $request->sizes[$j])->first();
                $product_size_quantity->color = $request->colors[$i];
                $product_size_quantity->size = $request->sizes[$j];
                $product_size_quantity->quantity = $request->quantity[$i*$totalQty/$totalColors+$j];
                $product_size_quantity->save();
            }
        }

        return 'level 2';

        // $insert = new Product;
        // $insert->categoryId = $request->category;
        // $insert->productName = $request->productName;
        // $insert->price = $request->price;
        // $insert->description = $request->description;
        // // $insert->rc_id = session()->get('subadminId');
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
