<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Modules\Seg\Services\NavigationService;
use App\Modules\Seg\Support\ActiveSystemResolver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $request = app(Request::class);
            $usuario = $request->user();

            $navigation = [];
            $activeSystemCode = ActiveSystemResolver::resolveCode($request);

            if ($usuario) {
                $navigation = app(NavigationService::class)->buildFor(
                    $usuario,
                    $activeSystemCode
                );
            }

            $view->with('navigation', $navigation)
                ->with('activeSystemCode', $activeSystemCode);
        });
    }
}