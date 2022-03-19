<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $shop = Shop::find($request->shop_id);
//            dd(auth()->id(), $product->user_id);
            if (auth()->id() === $shop->user_id) {
                $inputs = $request->all();
                $obj = new Product();
                $obj->fill($inputs);
                $obj->save();
                return response()->json(['message' => 'succes', 'status' => 1]);
            } else {
                return response()->json(['message' => 'You have no permission', 'status' => '0']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 0], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
            try {
                return response()->json([
                    'message' => 'succes',
                    'status' => 1,
                    'product' => Product::find($product)
                ]);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage(), 'status' => 0], 500);
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
