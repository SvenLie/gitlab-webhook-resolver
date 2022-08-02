<?php

namespace App\Http\Middleware;

use Closure;

class IsAuthenticatedForPipelineEvent
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
        if (!empty($request) && !empty($request['API_TOKEN']) && env('API_TOKEN_PIPELINE_EVENT') == $request['API_TOKEN']) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
