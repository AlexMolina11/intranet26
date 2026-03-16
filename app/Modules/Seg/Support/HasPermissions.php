<?php

namespace App\Modules\Seg\Support;

use App\Modules\Seg\Models\Permiso;

trait HasPermissions
{
    public function sistemasAutorizados()
    {
        return $this->sistemas()
            ->where('seg_usuario_sistema.activo', true)
            ->where('seg_sistemas.activo', true)
            ->orderBy('seg_sistemas.orden')
            ->orderBy('seg_sistemas.nombre');
    }

    public function tieneAccesoSistema(int $idSistema): bool
    {
        return $this->sistemasAutorizados()
            ->where('seg_sistemas.id_sistema', $idSistema)
            ->exists();
    }

    public function tienePermiso(?string $codigoPermiso): bool
    {
        if (blank($codigoPermiso)) {
            return true;
        }

        $permiso = Permiso::where('codigo', $codigoPermiso)->first();

        if (!$permiso) {
            return false;
        }

        if (!$this->tieneAccesoSistema((int) $permiso->id_sistema)) {
            return false;
        }

        $permisoDirecto = $this->permisosDirectos()
            ->where('seg_permisos.id_permiso', $permiso->id_permiso)
            ->first();

        if ($permisoDirecto) {
            return (bool) $permisoDirecto->pivot->permitido;
        }

        return $this->roles()
            ->where('seg_roles.id_sistema', $permiso->id_sistema)
            ->where('seg_roles.activo', true)
            ->whereHas('permisos', function ($query) use ($permiso) {
                $query->where('seg_permisos.id_permiso', $permiso->id_permiso);
            })
            ->exists();
    }

    public function permisosEfectivosCodigos(): array
    {
        $codigos = [];

        $permisosPorRol = Permiso::query()
            ->select('seg_permisos.codigo', 'seg_permisos.id_sistema')
            ->whereHas('roles', function ($query) {
                $query->whereHas('usuarios', function ($subQuery) {
                    $subQuery->where('seg_usuarios.id_usuario', $this->id_usuario);
                })->where('seg_roles.activo', true);
            })
            ->get();

        foreach ($permisosPorRol as $permiso) {
            if ($this->tieneAccesoSistema((int) $permiso->id_sistema)) {
                $codigos[$permiso->codigo] = true;
            }
        }

        $permisosDirectos = $this->permisosDirectos()->get();

        foreach ($permisosDirectos as $permisoDirecto) {
            if (!(bool) $permisoDirecto->pivot->permitido) {
                unset($codigos[$permisoDirecto->codigo]);
                continue;
            }

            if ($this->tieneAccesoSistema((int) $permisoDirecto->id_sistema)) {
                $codigos[$permisoDirecto->codigo] = true;
            }
        }

        return array_keys($codigos);
    }
}