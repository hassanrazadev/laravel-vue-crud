<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller {


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $products = Product::query()->paginate(12);
        return response()->json([
            'message' => '',
            'status' => true,
            'products' => $products
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        $request->validate([
            'name' => 'required',
            'short_description' => 'required|string|max:200',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'message' => 'Product created!',
            'status' => true,
            'product' => $product
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse {
        $product = Product::find($id);
        return response()->json([
            'message' => 'Product!',
            'status' => true,
            'product' => $product
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse {
        $product = Product::find($id);
        $product->update($request->except('product_image'));
        return response()->json([
            'message' => 'Product updated!',
            'status' => true,
            'product' => $product
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'message' => 'Product deleted!',
            'status' => true,
        ]);
    }
}
