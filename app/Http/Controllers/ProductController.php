<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Shop;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Product::all()->isEmpty()) {
            return response()->json([
                'message' => 'No data to be shown.']);
        }
        return response()->json([
            'data' => Product::all()]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        if (auth()->id()) {
            if (auth()->id() === Shop::findOrFail($request->shop_id)->user_id) {
                Product::create($request->all());
                return response()->json('New Product added successfully.');
            } else {
                return response()->json('Invalid shop id.');
            }
        } else {
            return response()->json('Please login.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $data = Product::findOrFail($id);
            return \response()->json($data);
        } catch (\Exception $e) {
            return response()->json("Invalid id, " . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            Product::findOrFail($id)->update($request->all());
            return response()->json('Changes made successfully.');
        } catch (\Exception $e) {
            return response()->json('Invalid id, ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Product::findOrFail($id)->delete();
            return response()->json("Deleted id $id.");
        } catch (\Exception $e) {
            return response()->json("Invalid id, " . $e->getMessage());
        }
    }
}
