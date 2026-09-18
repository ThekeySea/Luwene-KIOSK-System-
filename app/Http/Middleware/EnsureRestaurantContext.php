<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRestaurantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->branch_id === null && !in_array($user->role, ['CUSTOMER'])) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'NO_RESTAURANT_CONTEXT',
                    'message' => 'Tidak ada konteks restoran yang terhubung.',
                ],
            ], 400);
        }

        return $next($request);
    }
}
