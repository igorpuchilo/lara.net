<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
class CheckStatus
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
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
