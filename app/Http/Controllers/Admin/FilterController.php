<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filter;
use Validator;
use DB;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Filter::all();
        return view('admin.filter.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.filter.create');
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
            'filterName' => 'required'
        ],
        [
            'filterName.required' => 'Filter name cannot be Empty'
        ]);

        if($valid->fails()) {
            return back()->withErrors($valid);
        }

        $count = Filter::count();
        if($count >= 3) {
            return redirect()->route('filter.index')->with('success','Cannot add more than 3 Filters');
        }

        $insert = new Filter;
        $insert->filterName = $request->filterName;
        if($insert->save()) {
            return redirect()->route('filter.index')->with('success','Filter Added');
        } else {
            return redirect()->route('filter.index')->with('success','Oops! Some error Occured');
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
        $category = Filter::find($id);
        if($category->delete()) {
            return redirect()->route('filter.index')->with('success','Filter Deleted');
        } else {
            return redirect()->route('filter.index')->with('success','Oops! Some error Occured');
        }
    }
}
