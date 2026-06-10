<?php

namespace App\Modules\Bib\Services;

use App\Modules\Bib\Models\NotificacionBiblioteca;
use App\Modules\Seg\Models\Usuario;

class NotificacionBibliotecaService
{
    public function crearParaUsuario(
        int $idUsuario,
        string $tipo,
        string $titulo,
        string $mensaje,
        ?int $idPrestamo = null
    ): void {
        $existe = NotificacionBiblioteca::query()
            ->where('id_usuario', $idUsuario)
            ->where('tipo', $tipo)
            ->where('titulo', $titulo)
            ->where('mensaje', $mensaje)
            ->where('leida', false)
            ->exists();

        if ($existe) {
            return;
        }

        NotificacionBiblioteca::create([
            'id_usuario' => $idUsuario,
            'id_prestamo' => $idPrestamo,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'fecha_notificacion' => now()->toDateString(),
            'leida' => false,
            'activo' => true,
        ]);
    }

    public function crearParaBibliotecarios(
        string $tipo,
        string $titulo,
        string $mensaje,
        ?int $idPrestamo = null
    ): void {
        $usuarios = Usuario::query()
            ->where('activo', true)
            ->get()
            ->filter(fn ($usuario) => $usuario->tienePermiso('BIB_SOLICITUDES_GESTIONAR'));

        foreach ($usuarios as $usuario) {
            $this->crearParaUsuario(
                $usuario->id_usuario,
                $tipo,
                $titulo,
                $mensaje,
                $idPrestamo
            );
        }
    }
}