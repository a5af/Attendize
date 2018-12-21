<?php

namespace app\Http\Middleware;

use App\Models\Organiser;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Auth;

class FirstRunMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check BNS token
        if (!Auth::user()->hasRole(['owner', 'guest'])) {
            $token = session()->get('sso_token');
            $client = new Client();

            try {
                $response = $client->get(config('app.bns_url').'/api/myprofile?include=userDetail',[
                    'headers' => ['Authorization' => 'Bearer '.$token]
                ])->getBody();
            }catch (RequestException $e) {
                session()->flush();
                return redirect()->route('logout');
            }
        }

        /*
         * If there are no organisers then redirect the user to create one
         * else - if there's only one organiser bring the user straight there.
         */
        if (Organiser::scope()->count() === 0 && !($request->route()->getName() == 'showCreateOrganiser') && !($request->route()->getName() == 'postCreateOrganiser')) {
            return redirect(route('showCreateOrganiser', [
                'first_run' => '1',
            ]));
        } elseif (Organiser::scope()->count() === 1 && ($request->route()->getName() == 'showSelectOrganiser')) {
            return redirect(route('showOrganiserDashboard', [
                'organiser_id' => Organiser::scope()->first()->id,
            ]));
        }

        $response = $next($request);

        return $response;
    }
}
