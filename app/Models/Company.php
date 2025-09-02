<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'razon_social',
        'nombre_comercial',
        'direccion',
        'ubigeo',
        'distrito',
        'provincia',
        'departamento',
        'telefono',
        'email',
        'web',
        'usuario_sol',
        'clave_sol',
        'certificado_pem',
        'certificado_password',
        'endpoint_beta',
        'endpoint_produccion',
        'modo_produccion',
        'logo_path',
        'configuraciones',
        'activo',
    ];

    protected $casts = [
        'configuraciones' => 'array',
        'modo_produccion' => 'boolean',
        'activo' => 'boolean',
    ];

    protected $hidden = [
        'clave_sol',
        'certificado_pem',
        'certificado_password',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function boletas(): HasMany
    {
        return $this->hasMany(Boleta::class);
    }

    public function creditNotes(): HasMany
    {
        return $this->hasMany(CreditNote::class);
    }

    public function debitNotes(): HasMany
    {
        return $this->hasMany(DebitNote::class);
    }

    public function dispatchGuides(): HasMany
    {
        return $this->hasMany(DispatchGuide::class);
    }

    public function dailySummaries(): HasMany
    {
        return $this->hasMany(DailySummary::class);
    }

    public function voidedDocuments(): HasMany
    {
        return $this->hasMany(VoidedDocument::class);
    }

    public function getEndpointAttribute(): string
    {
        return $this->modo_produccion ? $this->endpoint_produccion : $this->endpoint_beta;
    }

    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }
}