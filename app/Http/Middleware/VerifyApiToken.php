<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiToken
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
        $apiKey = config('app.APP_API_KEY');

        $apiKeyIsValid = (
            ! empty($apiKey)
            && $request->header('x-api-key') == $apiKey
        );
        if(!$apiKeyIsValid){
            return response()->json([
                'cod'=>500,
                'msg'=>'Unauthorized',
            ]);
        }
        // abort_if (! $apiKeyIsValid, 500, 'Access denied');

        return $next($request);
    }
}
