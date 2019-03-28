<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AccountController;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', function($view)
        {
            $view->with('poule_saturday', IndexController::getPoulesonSaturday());
            $view->with('poule_sunday', IndexController::getPoulesonSunday());
            if(Auth::check())
            {
                $view->with('user', AccountController::getAdminUser(Auth::user()->id));
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
