<?php

namespace App\Modules\Bib\Services;

use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\PoliticaPrestamo;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Seg\Models\Usuario;

class CirculacionService
{
    public function validarUsuarioPuedePrestar(Usuario $usuario, Recurso $recurso): void
    {
        if ($this->usuarioTieneMultasPendientes($usuario)) {
            throw new \RuntimeException('El usuario posee multas pendientes de pago y no puede realizar nuevos préstamos.');
        }

        if ($this->usuarioTienePrestamosVencidos($usuario)) {
            throw new \RuntimeException('El usuario posee préstamos vencidos pendientes de devolución.');
        }

        if ($this->usuarioSuperaLimitePrestamos($usuario, $recurso)) {
            throw new \RuntimeException('El usuario alcanzó el máximo de préstamos activos permitidos para este tipo de recurso.');
        }
    }

    public function validarEjemplarPuedePrestar(Ejemplar $ejemplar): void
    {
        if ($ejemplar->disponibilidad?->codigo !== 'DISPONIBLE') {
            throw new \RuntimeException('El ejemplar seleccionado no está disponible para préstamo.');
        }

        if (in_array($ejemplar->estado?->codigo, ['DANADO', 'EXTRAVIADO', 'BAJA'], true)) {
            throw new \RuntimeException('El ejemplar seleccionado no puede prestarse por su estado físico.');
        }
    }

    private function usuarioTieneMultasPendientes(Usuario $usuario): bool
    {
        return Multa::query()
            ->where('id_usuario', $usuario->id_usuario)
            ->where('activo', true)
            ->where('pagada', false)
            ->exists();
    }

    private function usuarioTienePrestamosVencidos(Usuario $usuario): bool
    {
        return Prestamo::query()
            ->where('id_usuario', $usuario->id_usuario)
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereDate('fecha_vencimiento', '<', now()->toDateString())
            ->whereHas('estadoPrestamo', function ($query) {
                $query->where('codigo', 'ENTREGADO');
            })
            ->exists();
    }

    private function usuarioSuperaLimitePrestamos(Usuario $usuario, Recurso $recurso): bool
    {
        $politica = PoliticaPrestamo::query()
            ->where('id_tipo_recurso', $recurso->id_tipo_recurso)
            ->where('activo', true)
            ->first();

        $maximo = $politica?->max_prestamos_usuario ?? 3;

        $prestamosActivos = Prestamo::query()
            ->where('id_usuario', $usuario->id_usuario)
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereHas('estadoPrestamo', function ($query) {
                $query->whereIn('codigo', ['PENDIENTE_ENTREGA', 'ENTREGADO']);
            })
            ->whereHas('recurso', function ($query) use ($recurso) {
                $query->where('id_tipo_recurso', $recurso->id_tipo_recurso);
            })
            ->count();

        return $prestamosActivos >= $maximo;
    }
}