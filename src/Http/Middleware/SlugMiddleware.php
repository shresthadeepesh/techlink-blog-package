<?php


namespace Techlink\Blog\Http\Middleware;

use Closure;

class SlugMiddleware
{
    public function handle($request, Closure $next)
    {
        $request->route()->forgetParameter('slug');
        return $next($request);
    }
}