<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Modules\Seg\Services\NavigationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $usuario = auth()->user();

            $navigation = $usuario
                ? app(NavigationService::class)->buildFor($usuario)
                : [];

            $view->with('navigation', $navigation);
        });
    }
}
