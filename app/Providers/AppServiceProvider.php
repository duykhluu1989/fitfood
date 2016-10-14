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
        $this->publishes([
            __DIR__ . '/../../vendor/tinymce/tinymce/skins' => base_path('assets/js/skins'),
            __DIR__ . '/../../vendor/tinymce/tinymce/tinymce.min.js' => base_path('assets/js/tinymce.min.js'),
        ], 'tinymce');
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
