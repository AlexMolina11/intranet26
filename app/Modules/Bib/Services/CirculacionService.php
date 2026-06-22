<?php

namespace App\Modules\Bib\Services;

use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Seg\Models\Usuario;

class CirculacionService
{
    private const MAX_PRESTAMOS_ACTIVOS_GLOBAL = 3;

    public function validarUsuarioPuedePrestar(Usuario $usuario, Recurso $recurso): void
    {
        if ($this->usuarioTieneMultasPendientes($usuario)) {
            throw new \RuntimeException('El usuario posee multas pendientes de pago y no puede realizar nuevos préstamos.');
        }

        if ($this->usuarioTienePrestamosVencidos($usuario)) {
            throw new \RuntimeException('El usuario posee préstamos vencidos pendientes de devolución.');
        }

        if ($this->usuarioSuperaLimitePrestamos($usuario)) {
            throw new \RuntimeException('El usuario alcanzó el máximo de 3 préstamos activos permitidos.');
        }
    }

    public function validarUsuarioPuedeRenovar(Usuario $usuario): void
    {
        if ($this->usuarioTieneMultasPendientes($usuario)) {
            throw new \RuntimeException('El usuario posee multas pendientes de pago y no puede renovar préstamos.');
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
            ->where(function ($query) {
                $query->whereDate('fecha_vencimiento', '<', now()->toDateString())
                    ->orWhereHas('estadoPrestamo', function ($subquery) {
                        $subquery->where('codigo', 'VENCIDO');
                    });
            })
            ->whereHas('estadoPrestamo', function ($query) {
                $query->whereIn('codigo', ['ENTREGADO', 'VENCIDO']);
            })
            ->exists();
    }

    private function usuarioSuperaLimitePrestamos(Usuario $usuario): bool
    {
        $prestamosActivos = Prestamo::query()
            ->where('id_usuario', $usuario->id_usuario)
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereHas('estadoPrestamo', function ($query) {
                $query->whereIn('codigo', [
                    'PENDIENTE_ENTREGA',
                    'ENTREGADO',
                    'VENCIDO',
                ]);
            })
            ->count();

        return $prestamosActivos >= self::MAX_PRESTAMOS_ACTIVOS_GLOBAL;
    }
}