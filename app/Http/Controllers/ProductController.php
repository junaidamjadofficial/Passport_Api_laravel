<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id=$request->user()->id;
        $products=Product::where('user_id',$user_id)->get();
        return response()->json([
            'Product' => $products
        ],201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        Product::create([  'title' => $request->title,
        'user_id' => $request->user()->id,
        'description' => $request->description,
        'price' => $request->price]
          );
        return response()->json([
            'message' => 'User has been created Successfully'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::findOrFail($id);

        return response()->json($product,201);  
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
        $product=Product::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->user_id=$request->user()->id;
        $product->save();
        
        return response()->json([
            'message' => 'User has been updated Successfully'
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::where('id',$id)->delete();
        return response()->json([
            'message' => 'User has been deleted Successfully'
        ],201);
    }
}
