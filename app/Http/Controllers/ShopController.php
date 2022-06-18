<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 1,
            'data' => Shop::all()
        ]);
    }

    public function getPopulars()
    {
        return response()->json([
            'status' => 1,
            'data' => DB::table('shops')->orderBy('rating', 'desc')->limit(10)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShopRequest  $request
//     * @return \Illuminate\Http\Response
     * @return JsonResponse
     */
    public function store(StoreShopRequest $request)
    {
        try {
            $userId = auth()->id();
            //            $userId = auth()->user()->first_name;
            //            dd($userId);
            $inputs = $request->all();
            $inputs['user_id'] = $userId;
            $obj = new Shop();
            $obj->fill($inputs);
            $obj->save();
            return response()->json(['message' => 'succes', 'status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 0], 500);
        }
        // rating-@ petq e hanel $inputs-ic. update mej nuynpes
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $shop = Shop::query()->findOrFail($id);
            $products = Shop::query()->join('products', 'shops.id', '=', 'products.shop_id')->where('shops.id', '=', $id)->get();

            return response()->json([
                'message' => 'succes',
                'status' => 1,
                'shop' => $shop,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage(), 'status' => 0], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShopRequest  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
