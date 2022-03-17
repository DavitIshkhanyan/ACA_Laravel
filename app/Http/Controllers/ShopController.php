<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\returnArgument;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Shop::all()->isEmpty()) {
            return response()->json([
                'message' => 'No data to be shown.']);
        }
        return response()->json([
            'data' => Shop::all()]);
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
    public function store(StoreShopRequest $request)
    {
        Shop::create($request->all());
        return response()->json(
            'New Shop added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $data['Shop data'] = Shop::findOrFail($id);

            $data['Product data'] = DB::table('products')
                ->where('shop_id', '=', $id)
                ->select('*')
                ->paginate(5);

            if ($data['Product data']->isEmpty()) {
                $data['Product data'] = 'There are not any products in this shop.';
            }

            return \response()->json($data);
        } catch (\Exception $e) {
            Log::error('Invalid id');
            return response()->json("Invalid id, " . $e->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateShopRequest $request, $id)
    {
        try {
            Shop::findOrFail($id)->update($request->all());
            return response()->json('Changes made successfully.');
        } catch (\Exception $e) {
            Log::error("Invalid id, " . $e->getMessage());
            return response()->json('Invalid Id ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Shop::findOrFail($id)->delete();
            return response()->json("Deleted id $id.");
        } catch (\Exception $e) {
            Log::error("Invalid id, " . $e->getMessage());
            return response()->json("Invalid id, " . $e->getMessage());
        }
    }
}
