<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // register custom validation and compatibility aliases
        \Validator::extend('cek_passwordlama', function ($attribute, $value, $parameters) {
            return \Hash::check($value, $parameters[0]);
        });

        // Provide a compatibility alias for the removed Input facade
        if (! class_exists('Illuminate\\Support\\Facades\\Input')) {
            class_alias(\App\Support\Input::class, 'Illuminate\\Support\\Facades\\Input');
        }
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
