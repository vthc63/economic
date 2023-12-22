<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path().'/Helpers/admin/*.php') as $filename) {
            require_once($filename);
        }

        foreach (glob(app_path().'/Helpers/client/*.php') as $filename) {
            require_once($filename);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
