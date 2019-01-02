<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActivation
{
    public function handle($request , Closure $next)
    {
        if ($request->user()->is_activate == false) {
            return redirect('/plan');
        }
        return $next($request);
    }
}
