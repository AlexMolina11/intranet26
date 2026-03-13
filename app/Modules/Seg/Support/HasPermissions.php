<?php

namespace App\Modules\Seg\Support;

use App\Modules\Seg\Models\Permiso;

trait HasPermissions
{
    public function tieneAccesoSistema(int $idSistema): bool
    {
        return $this->sistemas()
            ->where('seg_sistemas.id_sistema', $idSistema)
            ->wherePivot('activo', true)
            ->exists();
    }

    public function tienePermiso(string $codigoPermiso): bool
    {
        $permiso = Permiso::where('codigo', $codigoPermiso)->first();

        if (!$permiso) {
            return false;
        }

        if (!$this->tieneAccesoSistema($permiso->id_sistema)) {
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
            ->whereHas('permisos', function ($query) use ($permiso) {
                $query->where('seg_permisos.id_permiso', $permiso->id_permiso);
            })
            ->exists();
    }
}