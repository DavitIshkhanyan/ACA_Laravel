<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB as FacadesDB;

use function PHPSTORM_META\type;

class ProductController extends Controller
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
            'data' => Product::all()
        ]);
    }

    public function getPopulars()
    {
        // echo asset('storage/file.txt');
        // echo asset('/var/www/public/laravel_shop/storage/app/public');
        // $images = [];
        $products = DB::table('products')->orderBy('rating', 'desc')->limit(10)->get();
        foreach ($products as $product) {
            // $images[] = DB::table('product_images')->where('product_id', $product->id)->where('default', 1)->first();
            $product->img = DB::table('product_images')->where('product_id', $product->id)->where('default', 1)->first();
        }
        // for ($i = 0; $i < count($products); $i++) {
        //     // dd(gettype($products[$i]));
        //     $products[$i]->img = DB::table('product_images')->where('product_id', $products[$i]->id)->where('default', 1)->first();
        // }
        return response()->json([
            'status' => 1,
            // 'data' => Product::all()->orderBy('id')->limit(2)->get()
            'data' => $products,
        ]);
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
            //            echo public_path('images/default.png');
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
                'product' => Product::find($product)[0]
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
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $shop = Shop::findOrFail($product->shop_id);
        if ($shop->user_id === auth()->id()) {
            $product->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Product deleted from cart'
            ]);
        } else {
            return response()->json([
                'status' => 2,
                'message' => 'This is not your product'
            ]);
        }
    }
}
