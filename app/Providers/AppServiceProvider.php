<?php

namespace App\Providers;

use App\Modules\Bib\Console\Commands\BibActualizarPrestamosVencidos;
use App\Modules\Bib\Console\Commands\BibGenerarRecordatoriosPrestamos;
use App\Modules\Bib\Models\NotificacionBiblioteca;
use App\Modules\Seg\Services\NavigationService;
use App\Modules\Seg\Support\ActiveSystemResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

            $notificacionesGlobales = collect();
            $notificacionesGlobalesPendientes = 0;

            if ($usuario) {
                $navigation = app(NavigationService::class)->buildFor(
                    $usuario,
                    $activeSystemCode
                );

                $notificacionesGlobales = NotificacionBiblioteca::query()
                    ->where('activo', true)
                    ->where('id_usuario', $usuario->id_usuario)
                    ->where('leida', false)
                    ->latest('id_notificacion')
                    ->limit(10)
                    ->get();

                $notificacionesGlobalesPendientes = NotificacionBiblioteca::query()
                    ->where('activo', true)
                    ->where('id_usuario', $usuario->id_usuario)
                    ->where('leida', false)
                    ->count();
            }

            $view->with('navigation', $navigation)
                ->with('activeSystemCode', $activeSystemCode)
                ->with('notificacionesGlobales', $notificacionesGlobales)
                ->with('notificacionesGlobalesPendientes', $notificacionesGlobalesPendientes);
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
