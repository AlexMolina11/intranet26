<?php

namespace App\Providers;

use App\Modules\Bib\Console\Commands\BibActualizarPrestamosVencidos;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Modules\Seg\Services\NavigationService;
use App\Modules\Seg\Support\ActiveSystemResolver;
use App\Modules\Bib\Console\Commands\BibGenerarRecordatoriosPrestamos;

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

        $this->loadMigrationsFrom([
            database_path('migrations/bib'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                BibActualizarPrestamosVencidos::class,
                BibGenerarRecordatoriosPrestamos::class,
            ]);
        }
    }
}