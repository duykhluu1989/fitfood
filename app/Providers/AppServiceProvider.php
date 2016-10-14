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
            __DIR__ . '/../../vendor/tinymce/tinymce/plugins' => base_path('assets/js/tinymce/plugins'),
            __DIR__ . '/../../vendor/tinymce/tinymce/skins' => base_path('assets/js/tinymce/skins'),
            __DIR__ . '/../../vendor/tinymce/tinymce/themes' => base_path('assets/js/tinymce/themes'),
            __DIR__ . '/../../vendor/tinymce/tinymce/jquery.tinymce.min.js' => base_path('assets/js/tinymce/jquery.tinymce.min.js'),
            __DIR__ . '/../../vendor/tinymce/tinymce/tinymce.jquery.min.js' => base_path('assets/js/tinymce/tinymce.jquery.min.js'),
            __DIR__ . '/../../vendor/tinymce/tinymce/tinymce.min.js' => base_path('assets/js/tinymce/tinymce.min.js'),
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
