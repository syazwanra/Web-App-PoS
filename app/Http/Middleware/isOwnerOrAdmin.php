<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Roles;

class isOwnerOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = auth()->user();

        // Cek apakah peran user adalah admin atau owner
        $roleOwner = Roles::where('name', 'owner')->first();
        $roleAdmin = Roles::where('name', 'admin')->first();

        if ($currentUser->role_id === $roleOwner->id || $currentUser->role_id === $roleAdmin->id) {
            return $next($request);
        }

        // Jika bukan owner atau admin
        return response()->json([
            'message' => 'Only owner and admin can access this resource.'
        ], 401);
    }
}
