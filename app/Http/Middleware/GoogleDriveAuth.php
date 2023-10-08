<?php

namespace App\Http\Middleware;

use App\Helpers\{AuthCommon,GoogleClient};
use Closure;
use Illuminate\Http\Request;

class GoogleDriveAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $auth = AuthCommon::user();
        if(isset($auth->username)){
           
            $google = new GoogleClient();
            $is_logged_in = $google->isLoggedIn();

            app("session")->put("is_google_login", $is_logged_in);

        }

        return $next($request);
    }
}
