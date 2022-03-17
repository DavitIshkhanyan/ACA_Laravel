<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => trans('shop.success'),
            'data' => Category::all()
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());
        return response()->json([
            'message' => 'New Category added successfully.',
            'data' => $category
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $data['Category data'] = Category::findOrFail($id);

            $data['Product data'] = DB::table('products')
                ->select('*')
                ->where('category', '=', $id)
                ->paginate(5);

            if ($data['Product data']->isEmpty()) {
                $data['Product data'] = 'There are not any products with this category.';
            }

            return response()->json($data);
        } catch (Exception $e) {
            Log::error('Invalid id');
            return response()->json('Invalid id, ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {
        try {
            Category::findOrFail($id)->update($request->all());
            return response()->json('Changes made successfully.');
        } catch (Exception $e) {
            return response()->json('Invalid id, ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            Category::findOrFail($id)->delete();
            return response()->json("Deleted id $id.");
        } catch (Exception $e) {
            return response()->json('Invalid id, ' . $e->getMessage());
        }

    }
}
