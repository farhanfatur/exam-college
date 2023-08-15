<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\SeriesNumber;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Products::all();

        return view("product.index", ["products" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("product.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
    		'product_name' => 'required|max:50',
    		'brand_name' => 'required',
            'price' => 'required',
			'model_no' => 'required',
    	]);

        $product = new Products;
        $product->product_name = $request->product_name;
        $product->brand_name = $request->brand_name;
        $product->price = $request->price;
        $product->model_no = $request->model_no;
        $product->save();

        $seriesNumber = new SeriesNumber;
        $seriesNumber->product_id = $product->id;
        $seriesNumber->series_no = $request->series_no;
        $seriesNumber->price = $request->price;
        $seriesNumber->prod_date = $request->prod_date;
        $seriesNumber->warranty_start = $request->warranty_start;
        $seriesNumber->warranty_duration = $request->warranty_duration;
        $seriesNumber->used = null;
        $seriesNumber->save();

        return view("product.index", ["success" => true, "message" => "Insert data is success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::find($id);

        return view("product.show", ["product" => $product]);
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
        $product = Products::find($id);

        if (!$product) {
            return view("product.index", ["success" => false, "message" => "Product is not found"]);
        }

        $product->product_name = $request->product_name;
        $product->brand_name = $request->brand_name;
        $product->price = $request->price;
        $product->model_no = $request->model_no;
        $product->save();

        $seriesNumber = new SeriesNumber;
        $seriesNumber->where("product_id", $product->id);
        
        $seriesNumber->series_no = $request->series_no;
        $seriesNumber->price = $request->price;
        $seriesNumber->prod_date = $request->prod_date;
        $seriesNumber->warranty_start = $request->warranty_start;
        $seriesNumber->warranty_duration = $request->warranty_duration;
        $seriesNumber->used = null;
        $seriesNumber->save();

        return view("product.index", ["success" => true, "message" => "Update product is success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        if (!$product) {
            return view("product.index", ["success" => false, "message" => "Product is not found"]);
        }

        $product->delete();

        $seriesNumber = SeriesNumber::where("product_id", $product->id);
        if (!$seriesNumber) {
            return view("product.index", ["success" => false, "message" => "Product is not found"]);
        }

        $seriesNumber->delete();

        return view("product.index", ["success" => true, "message" => "Delete product is success"]);
    }
}
