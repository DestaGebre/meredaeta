<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DateConvert;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('ethiopian_date', function($attribute, $value, $parameters){
            return DateConvert::dateValidation($value);
        })  ; 
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
