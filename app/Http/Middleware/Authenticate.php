<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                $token = substr($request->header('Authorization'), 7);
                $client = new Client();
                try {
                    $response = $client->get(config('app.bns_url').'/api/myprofile?include=userDetail',[
                        'headers' => ['Authorization' => 'Bearer '.$token]
                    ])->getBody();
                }catch (RequestException $e) {
                    return response('Unauthorized.', 401);
                }
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}