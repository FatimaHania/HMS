<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NavigationComposerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->composeNavigation();

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


    public function composeNavigation()
    {

        view()->composer('layouts.menu' , 'App\Http\Composers\NavigationComposer');

    }

}
