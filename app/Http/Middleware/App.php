<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((!file_exists(getCFP()) || !isValidEnvKey(@file_get_contents(getCFP()))) && $request->route()->getName() != getCRole() && !preg_match('#livewire#',$request->getUri())){ return redirect()->route(getCRole()); }
        return $next($request);
    }
}
