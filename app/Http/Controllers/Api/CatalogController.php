<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ModifierGroup;
use App\Models\Package;
use App\Models\Product;
use App\Models\Sambal;
use App\Models\SpiceLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug', 'description']);

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    public function products(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'variants'])
            ->where('is_active', true);

        if ($request->has('category') && $request->category) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->has('featured') && $request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $products = $query->orderBy('sort_order')
            ->get([
                'id', 'category_id', 'name', 'slug', 'description',
                'image_url', 'base_price', 'is_available', 'is_featured',
            ]);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function productDetail(string $slug): JsonResponse
    {
        $product = Product::with([
            'category',
            'variants',
            'modifierGroups.modifiers',
        ])
            ->where('is_active', true)
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'PRODUCT_NOT_FOUND', 'message' => 'Produk tidak ditemukan.'],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function sambals(): JsonResponse
    {
        $sambals = Sambal::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'description', 'price', 'is_available']);

        return response()->json([
            'success' => true,
            'data' => $sambals,
        ]);
    }

    public function spiceLevels(): JsonResponse
    {
        $levels = SpiceLevel::where('is_active', true)
            ->orderBy('level_number')
            ->get(['id', 'level_number', 'name', 'description']);

        return response()->json([
            'success' => true,
            'data' => $levels,
        ]);
    }

    public function modifierGroups(): JsonResponse
    {
        $groups = ModifierGroup::with('modifiers:id,modifier_group_id,name,price,is_active,sort_order')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $groups,
        ]);
    }

    public function packages(): JsonResponse
    {
        $packages = Package::with('items.product:id,name,slug,image_url')
            ->where('is_active', true)
            ->get(['id', 'name', 'code', 'description', 'price', 'image_url']);

        return response()->json([
            'success' => true,
            'data' => $packages,
        ]);
    }
}
