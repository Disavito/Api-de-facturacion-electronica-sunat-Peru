<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispatchGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'branch_id',
        'destinatario_id', // Client como destinatario
        'tipo_documento',
        'serie',
        'correlativo',
        'numero_completo',
        'fecha_emision',
        'version',
        
        // Datos del envío
        'cod_traslado',
        'des_traslado',
        'mod_traslado',
        'fec_traslado',
        'peso_total',
        'und_peso_total',
        'num_bultos',
        
        // Direcciones
        'partida_ubigeo',
        'partida_direccion',
        'llegada_ubigeo', 
        'llegada_direccion',
        
        // Transportista (si es transporte público)
        'transportista_tipo_doc',
        'transportista_num_doc',
        'transportista_razon_social',
        'transportista_nro_mtc',
        
        // Conductor (si es transporte privado)
        'conductor_tipo',
        'conductor_tipo_doc',
        'conductor_num_doc',
        'conductor_licencia',
        'conductor_nombres',
        'conductor_apellidos',
        
        // Vehículo principal
        'vehiculo_placa',
        
        // Vehículos secundarios
        'vehiculos_secundarios',
        
        // Detalles de productos
        'detalles',
        
        // Observaciones
        'observaciones',
        
        // Archivos generados
        'xml_path',
        'cdr_path',
        'pdf_path',
        
        // Estado SUNAT
        'estado_sunat',
        'respuesta_sunat',
        'ticket',
        'codigo_hash',
        
        // Auditoría
        'usuario_creacion',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fec_traslado' => 'date',
        'peso_total' => 'decimal:2',
        'num_bultos' => 'integer',
        'vehiculos_secundarios' => 'array',
        'detalles' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'destinatario_id');
    }

    public function getTipoDocumentoNameAttribute(): string
    {
        return 'Guía de Remisión Electrónica';
    }

    public function getModalidadTrasladoNameAttribute(): string
    {
        return match($this->mod_traslado) {
            '01' => 'Transporte público',
            '02' => 'Transporte privado',
            default => 'Modalidad no especificada'
        };
    }

    public function getMotivoTrasladoNameAttribute(): string
    {
        return match($this->cod_traslado) {
            '01' => 'Venta',
            '02' => 'Compra',
            '03' => 'Venta con entrega a terceros',
            '04' => 'Traslado entre establecimientos de la misma empresa',
            '05' => 'Consignación',
            '06' => 'Devolución',
            '07' => 'Recojo de bienes transformados',
            '08' => 'Importación',
            '09' => 'Exportación',
            '13' => 'Otros',
            '14' => 'Venta sujeta a confirmación del comprador',
            '18' => 'Traslado de bienes para transformación',
            '19' => 'Traslado de bienes desde un centro de acopio',
            default => $this->des_traslado ?? 'Motivo no especificado'
        };
    }

    public function getEstadoSunatColorAttribute(): string
    {
        return match($this->estado_sunat) {
            'PENDIENTE' => 'warning',
            'PROCESANDO' => 'info',
            'ACEPTADO' => 'success',
            'RECHAZADO' => 'danger',
            default => 'secondary'
        };
    }

    public function scopePending($query)
    {
        return $query->where('estado_sunat', 'PENDIENTE');
    }

    public function scopeProcessing($query)
    {
        return $query->where('estado_sunat', 'PROCESANDO');
    }

    public function scopeAccepted($query)
    {
        return $query->where('estado_sunat', 'ACEPTADO');
    }

    public function scopeRejected($query)
    {
        return $query->where('estado_sunat', 'RECHAZADO');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('fecha_emision', [$startDate, $endDate]);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($guide) {
            if (empty($guide->numero_completo)) {
                $guide->numero_completo = $guide->serie . '-' . $guide->correlativo;
            }
        });
    }
}
