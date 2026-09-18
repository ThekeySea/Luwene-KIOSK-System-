<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\RestaurantTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function context(Request $request): JsonResponse
    {
        $branch = Branch::where('status', 'ACTIVE')->first();

        if (!$branch) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'NO_BRANCH', 'message' => 'Tidak ada restoran aktif.'],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $branch->id,
                'code' => $branch->code,
                'name' => $branch->name,
                'address' => $branch->address,
            ],
        ]);
    }

    public function resolveTable(Request $request, string $qrToken): JsonResponse
    {
        $branch = Branch::where('status', 'ACTIVE')->first();

        $table = RestaurantTable::where('branch_id', $branch->id)
            ->where('qr_token_hash', $qrToken)
            ->first();

        if (!$table) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'TABLE_NOT_FOUND', 'message' => 'Meja tidak ditemukan.'],
            ], 404);
        }

        if ($table->status === 'INACTIVE') {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'TABLE_INACTIVE', 'message' => 'Meja tidak aktif.'],
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $table->id,
                'table_number' => $table->table_number,
                'capacity' => $table->capacity,
                'status' => $table->status,
            ],
        ]);
    }
}
