<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Seg\Models\Usuario;
use App\Modules\Org\Models\Departamento;
use App\Modules\Org\Models\Proyecto;
use App\Modules\Tik\Models\SoporteDetalle;

class Soporte extends Model
{
    use SoftDeletes;

    protected $table = 'tik_soportes';
    protected $primaryKey = 'id_soporte';

    protected $fillable = [
        'id_ticket',
        'id_usuario_gestor',
        'id_usuario_solicitante',
        'id_departamento',
        'id_proyecto',
        'id_seccion',
        'id_servicio',
        'id_incidencia',
        'tipo_registro',
        'asunto',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'notificado_at',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'notificado_at' => 'datetime',
        'activo' => 'boolean',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    public function gestor()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_gestor', 'id_usuario');
    }

    public function solicitante()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_solicitante', 'id_usuario');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'id_seccion', 'id_seccion');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'id_incidencia', 'id_incidencia');
    }

    public function getFechaInicioFormateadaAttribute(): string
    {
        return $this->fecha_inicio
            ? $this->fecha_inicio->format('d/m/Y h:i a')
            : 'Sin definir';
    }

    public function getFechaFinFormateadaAttribute(): string
    {
        return $this->fecha_fin
            ? $this->fecha_fin->format('d/m/Y h:i a')
            : 'Sin definir';
    }

    public function getFechaRegistroFormateadaAttribute(): string
    {
        return $this->created_at
            ? $this->created_at->format('d/m/Y h:i a')
            : 'Sin definir';
    }

    public function getFueNotificadoAttribute(): bool
    {
        return !is_null($this->notificado_at);
    }

    public function detalles()
    {
        return $this->hasMany(SoporteDetalle::class, 'id_soporte', 'id_soporte')
            ->latest('id_soporte_detalle');
    }
}