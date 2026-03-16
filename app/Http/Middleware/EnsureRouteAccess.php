<?php

namespace App\Http\Middleware;

use App\Modules\Seg\Models\MenuItem;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRouteAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'No autorizado.');
        }

        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return $next($request);
        }

        if (in_array($routeName, ['inicio', 'dashboard', 'logout'], true)) {
            return $next($request);
        }

        $routePermissions = config('access.route_permissions', []);

        if (array_key_exists($routeName, $routePermissions)) {
            $requiredPermission = $routePermissions[$routeName];

            if (!blank($requiredPermission) && !$user->tienePermiso($requiredPermission)) {
                abort(403, 'No tienes permiso para acceder a esta ruta.');
            }

            return $next($request);
        }

        $menuItem = MenuItem::where('ruta', $routeName)->first();

        if ($menuItem) {
            if (!$user->tieneAccesoSistema((int) $menuItem->id_sistema)) {
                abort(403, 'No tienes acceso a este sistema.');
            }

            if (!$user->tienePermiso($menuItem->permiso_requerido)) {
                abort(403, 'No tienes permiso para acceder a esta opción.');
            }
        }

        return $next($request);
    }
}