<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Enregistrer l'alias middleware 'jwt' pour permettre l'utilisation de 'jwt:admin' dans les routes
        $this->app->booted(function () {
            $router = $this->app->make(Router::class);
            $router->aliasMiddleware('jwt', \App\Http\Middleware\JwtRoleMiddleware::class);
            // Alias pour l'authentification via JWT (vérifie la présence et la validité du token)
            $router->aliasMiddleware('jwt.auth', \App\Http\Middleware\JwtMiddleware::class);
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}