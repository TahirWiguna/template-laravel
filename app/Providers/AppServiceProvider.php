<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $force_https = (bool) env('FORCE_HTTPS', false);
        $except_https = env('EXCEPT_HTTPS');

        $except_https = explode(',', $except_https);
        $base_url = \URL::to('/');

        if($force_https) {
            if(!in_array($base_url, $except_https)){
                config(['session.secure' => true]);
                \URL::forceScheme('https');
            }
        }
    }
}
