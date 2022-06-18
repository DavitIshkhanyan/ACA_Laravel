<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user_id = auth()->id();
        //        $products = Cart::where('user_id', $user_id)->get();
        $products = Cart::where('user_id', $user_id)->paginate(2);
        return response()->json([
            'status' => 1,
            'data' => $products,
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return JsonResponse
     */
    public function store(StoreCartRequest $request): JsonResponse
    {
        $inputs = $request->all();
        //        dd($inputs);
        $inputs['user_id'] = auth()->id();
        //        dd($inputs['user_id']);
        $product = Product::findOrFail($request->product_id);
        try {
            if (Cart::query()
                ->where('product_id', $request->product_id)
                ->where('user_id', $inputs['user_id'])
                ->exists()
            ) {
                $cart = Cart::query()
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $inputs['user_id'])
                    ->get()[0];
                $alreadyExistsCount = $cart->count;
                $newCount = $alreadyExistsCount + $inputs['count'];
                if ($product->count >= $newCount) {
                    $cart->count = $newCount;
                    $cart->save();
                    return response()->json([
                        'status' => 1,
                        'message' => 'success'
                    ]);
                } else {
                    return response()->json([
                        'status' => 2,
                        'message' => 'There is no enough count of product in shop'
                    ]);
                }
            } else {
                if ($product->count >= $request->count) {
                    Cart::create($inputs);
                    return response()->json(['message' => 'succes', 'status' => 1]);
                } else {
                    return response()->json([
                        'status' => 2,
                        'message' => 'There is no enough count of product in shop'
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 0], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    //    public function show(Cart $cart)
    //    {
    //        //
    //    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCartRequest  $request
     * @param  \App\Models\Cart  $cart
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $product = Product::findOrFail($id);
        $cart = Cart::findOrFail($product->id);
        $user_id = $cart->user_id;

        if ($user_id === auth()->id()) {
            if ($product->count >= $request->count) {
                $cart->count = $request->count;
                $cart->save();
                return response()->json([
                    'status' => 1,
                    'message' => 'succes'
                ]);
            } else {
                return response()->json([
                    'status' => 2,
                    'message' => 'There is no enough count of product in shop'
                ]);
            }
        } else {
            return response()->json([
                'status' => 2,
                'message' => 'This is not your product'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $cart  = Cart::findOrFail($product->id);
        $user_id = $cart->user_id;
        if ($user_id === auth()->id()) {
            $cart->delete(); //stugel ashxatum e te che
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

    public function checkOut(): JsonResponse
    {
        $user_id = auth()->id();
        $cartItems = Cart::query()
            ->with('product')
            ->where('user_id', $user_id)
            ->get();

        $productsInfo = [];
        $sum = 0;
        // dd($cartItems);
        foreach ($cartItems as $cartItem) {
            // dd(1);

            // dd($cartItem->count);

            //            dd($cartItem->count);
            //            dd($cartItem->product->count);
            if ($cartItem->product->count >= $cartItem->count) {
                $productsInfo[] = [
                    'id' => $cartItem->product_id,
                    'name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'count' => $cartItem->count
                ];
                $sum += $cartItem->product->price * $cartItem->count;
            } else {
                return response()->json([
                    'status' => 2,
                    'message' => 'This is not your product'
                ]);
            }
        }
        $order = new Order();
        $order->user_id = $user_id;

        $order->products = json_encode($productsInfo);

        $order->sum = $sum;
        $order->status = 0;
        // dd($order);

        $order->save();
        return response()->json([
            'status' => 1,
            'message' => 'success'
        ]);
    }
}
