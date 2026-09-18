<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureRestaurantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->branch_id && ! Session::get('active_branch_id')) {
            Session::put('active_branch_id', $user->branch_id);
        }

        return $next($request);
    }
}
