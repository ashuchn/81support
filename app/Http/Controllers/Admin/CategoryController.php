<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use DB;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        return view('admin.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'categoryName' => 'required'
        ],
        [
            'categoryName.required' => 'Category name cannot be Empty'
        ]);

        if($valid->fails()) {
            return back()->withErrors($valid);
        }

        $insert = new Category;
        $insert->categoryName = $request->categoryName;
        if($insert->save()) {
            return redirect()->route('category.index')->with('success','Category Added');
        } else {
            return redirect()->route('category.index')->with('success','Oops! Some error Occured');
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
        $category =  Category::where('id', $id)->pluck('categoryName');
        $data = Product::where('categoryId', $id)->paginate(5);
        if(!empty($data)) {
            //for appending server url to public url
            foreach($data as $rows) {
                // return $new;
                $images = DB::table('product_images')->where('productId', $rows->id)->get('product_images.image')->toArray();
                $new = array();
                foreach($images as $image) {
                    $url = url('/').'/'.$image->image;
                    array_push($new, $url);
                }
                $rows->images = $new;
            }
        }
        // return $data;
        return view('admin.category.products', compact('data','category'));
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
        $category = Category::find($id);
        if($category->delete()) {
            return redirect()->route('category.index')->with('success','Category Deleted');
        } else {
            return redirect()->route('category.index')->with('success','Oops! Some error Occured');
        }
    }
}
