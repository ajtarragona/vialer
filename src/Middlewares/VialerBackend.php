<?php

namespace Ajtarragona\Vialer\Middlewares;

use Closure;

class VialerBackend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	if (!config("vialer.backend")) {
    		 $error=__("Oops! Vialer is disabled");
    		 return view("vialer::error",compact('error'));
        }

        return $next($request);
    }
}