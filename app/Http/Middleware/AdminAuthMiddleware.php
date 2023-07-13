<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || $user->role->alias === User::ROLE_ADMIN) {
            return redirect()->to('/admin/login');
        }
        return $next($request);
    }
}
