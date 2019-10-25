<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
class CheckStatus
{

    /**
     * Check user role for Admin
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->isAdministrator()) {//
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
