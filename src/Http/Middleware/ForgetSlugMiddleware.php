<?php

namespace Techlink\Blog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForgetSlugMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->route('slug')) {
            $request->route()->forgetParameter('slug');
        }

        return $next($request);
    }
}