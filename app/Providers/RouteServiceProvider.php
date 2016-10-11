<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $adminNamespace = 'App\Admin\Http\Controllers';
    protected $webNamespace = 'App\Beta\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        if(strpos(request()->url(), '/admin') !== false)
        {
            $router->group([
                'namespace' => $this->adminNamespace, 'middleware' => 'web',
            ], function ($router) {
                require app_path('Admin/Http/routes.php');
            });
        }
        else
        {
            $router->group([
                'namespace' => $this->webNamespace, 'middleware' => 'web',
            ], function ($router) {
                require app_path('Beta/Http/routes.php');
            });
        }
    }
}
