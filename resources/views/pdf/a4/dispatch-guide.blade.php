@extends('pdf.layouts.a4')

@section('content')
    {{-- Header --}}
    @include('pdf.components.header', [
        'company' => $company, 
        'document' => $document, 
        'tipo_documento_nombre' => 'GUÍA DE REMISIÓN ELECTRÓNICA',
        'fecha_emision' => $fecha_emision,
        'format' => 'a4'
    ])

    {{-- Información del Traslado --}}
    <div class="dispatch-info-section">
        <h3 class="section-title">INFORMACIÓN DEL TRASLADO</h3>
        <div class="dispatch-info-grid">
            <div class="dispatch-info-item">
                <span class="label">FECHA EMISIÓN:</span>
                <span class="value">{{ $fecha_emision }}</span>
            </div>
            <div class="dispatch-info-item">
                <span class="label">FECHA TRASLADO:</span>
                <span class="value">{{ $fecha_traslado }}</span>
            </div>
            <div class="dispatch-info-item">
                <span class="label">MOTIVO TRASLADO:</span>
                <span class="value">{{ $motivo_traslado ?? 'VENTA' }}</span>
            </div>
            <div class="dispatch-info-item">
                <span class="label">MODALIDAD:</span>
                <span class="value">{{ $modalidad_traslado ?? 'TRANSPORTE PRIVADO' }}</span>
            </div>
            <div class="dispatch-info-item">
                <span class="label">PESO TOTAL:</span>
                <span class="value">{{ $peso_total_formatted ?? '0.000 KGM' }}</span>
            </div>
            <div class="dispatch-info-item">
                <span class="label">N° BULTOS:</span>
                <span class="value">{{ $document->num_bultos ?? '1' }}</span>
            </div>
        </div>
    </div>

    {{-- Datos del Destinatario y Direcciones --}}
    <div class="client-dispatch-info">
        <div class="client-section">
            <h4>DATOS DEL DESTINATARIO</h4>
            <div class="client-data">
                <p><strong>RAZÓN SOCIAL:</strong> {{ $destinatario->razon_social ?? 'DESTINATARIO' }}</p>
                <p><strong>{{ ($destinatario->tipo_documento ?? '6') == '6' ? 'RUC' : 'DNI' }}:</strong> {{ $destinatario->numero_documento ?? '' }}</p>
                @if(!empty($destinatario->direccion ?? ''))
                <p><strong>DIRECCIÓN:</strong> {{ $destinatario->direccion }}</p>
                @endif
            </div>
        </div>
        
        <div class="addresses-section">
            <h4>PUNTOS DE TRASLADO</h4>
            <div class="addresses-data">
                <p><strong>PUNTO PARTIDA:</strong> {{ $document->partida['direccion'] ?? $document->partida_direccion ?? 'Dirección de partida' }}</p>
                <p><strong>UBIGEO PARTIDA:</strong> {{ $document->partida['ubigeo'] ?? $document->partida_ubigeo ?? '' }}</p>
                <p><strong>PUNTO LLEGADA:</strong> {{ $document->llegada['direccion'] ?? $document->llegada_direccion ?? 'Dirección de llegada' }}</p>
                <p><strong>UBIGEO LLEGADA:</strong> {{ $document->llegada['ubigeo'] ?? $document->llegada_ubigeo ?? '' }}</p>
            </div>
        </div>
    </div>

    {{-- Datos del Transporte --}}
    @if(($document->mod_traslado ?? '02') == '01')
    {{-- Transporte Público --}}
    <div class="transport-info">
        <h4>DATOS DEL TRANSPORTISTA</h4>
        @php $transportista = $document->transportista ?? []; @endphp
        <div class="transport-data">
            <div class="transport-col">
                <p><strong>TRANSPORTISTA:</strong> {{ $transportista['razon_social'] ?? $document->transportista_razon_social ?? 'TRANSPORTISTA' }}</p>
                <p><strong>RUC:</strong> {{ $transportista['num_doc'] ?? $document->transportista_num_doc ?? '' }}</p>
                @if(!empty($transportista['nro_mtc'] ?? $document->transportista_nro_mtc ?? ''))
                <p><strong>N° MTC:</strong> {{ $transportista['nro_mtc'] ?? $document->transportista_nro_mtc }}</p>
                @endif
            </div>
            <div class="transport-col">
                @php 
                    $vehiculo = $document->vehiculo ?? [];
                    $vehiculos_secundarios = $document->vehiculos_secundarios ?? [];
                    if (is_string($vehiculos_secundarios)) {
                        $vehiculos_secundarios = json_decode($vehiculos_secundarios, true) ?: [];
                    }
                @endphp
                <p><strong>VEHÍCULO PRINCIPAL:</strong> {{ $vehiculo['placa_principal'] ?? $document->vehiculo_placa ?? 'N/A' }}</p>
                @if($vehiculos_secundarios)
                    @foreach($vehiculos_secundarios as $index => $vehiculo_sec)
                    <p><strong>VEHÍCULO {{ $index + 2 }}:</strong> {{ $vehiculo_sec['placa'] ?? 'N/A' }}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif

    @if(($document->mod_traslado ?? '02') == '02')
    {{-- Transporte Privado --}}
    <div class="transport-info">
        <h4>DATOS DEL CONDUCTOR Y VEHÍCULO</h4>
        @php 
            $vehiculo = $document->vehiculo ?? [];
            $conductor = $vehiculo['conductor'] ?? [];
        @endphp
        <div class="transport-data">
            <div class="transport-col">
                <p><strong>CONDUCTOR:</strong> {{ $conductor['nombres'] ?? $document->conductor_nombres ?? 'CONDUCTOR' }} {{ $conductor['apellidos'] ?? $document->conductor_apellidos ?? '' }}</p>
                <p><strong>DNI:</strong> {{ $conductor['num_doc'] ?? $document->conductor_num_doc ?? '' }}</p>
                <p><strong>LICENCIA:</strong> {{ $conductor['licencia'] ?? $document->conductor_licencia ?? '' }}</p>
            </div>
            <div class="transport-col">
                <p><strong>VEHÍCULO:</strong> {{ $vehiculo['placa_principal'] ?? $document->vehiculo_placa ?? 'N/A' }}</p>
                @if(!empty($vehiculo['placa_secundaria'] ?? ''))
                <p><strong>VEHÍCULO 2:</strong> {{ $vehiculo['placa_secundaria'] }}</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Tabla de Detalles --}}
    @include('pdf.components.dispatch-items-table', [
        'detalles' => $detalles,
        'format' => 'a4'
    ])

    {{-- Observaciones --}}
    @if($document->observaciones ?? null)
    <div class="observations-section">
        <h4>OBSERVACIONES</h4>
        <p>{{ $document->observaciones }}</p>
    </div>
    @endif

    {{-- Footer --}}
    @include('pdf.components.dispatch-footer', [
        'document' => $document,
        'company' => $company,
        'tipo_documento_nombre' => 'GUÍA DE REMISIÓN ELECTRÓNICA',
        'format' => 'a4'
    ])
@endsection

@section('styles')
    <style>
        /* Estilos específicos para guías de remisión */
        .dispatch-info-section {
            margin: 15px 0;
            padding: 12px;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            background-color: #f1f8e9;
        }

        .section-title {
            margin: 0 0 12px 0;
            color: #4CAF50;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .dispatch-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .dispatch-info-item {
            display: flex;
            align-items: center;
        }

        .dispatch-info-item .label {
            font-weight: bold;
            font-size: 10px;
            width: 120px;
            flex-shrink: 0;
        }

        .dispatch-info-item .value {
            font-size: 10px;
            flex: 1;
        }

        .client-dispatch-info {
            display: flex;
            margin: 15px 0;
            gap: 20px;
        }

        .client-section,
        .addresses-section {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #fafafa;
        }

        .client-section h4,
        .addresses-section h4,
        .transport-info h4 {
            margin: 0 0 10px 0;
            font-size: 12px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .client-data p,
        .addresses-data p,
        .transport-data p {
            margin: 5px 0;
            font-size: 11px;
            line-height: 1.4;
        }

        .transport-info {
            margin: 15px 0;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #fafafa;
        }

        .transport-data {
            display: flex;
            gap: 20px;
        }

        .transport-col {
            flex: 1;
        }

        .observations-section {
            margin: 15px 0;
            padding: 12px;
            border: 1px solid #f0ad4e;
            border-radius: 6px;
            background-color: #fdf6e3;
        }

        .observations-section h4 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #f0ad4e;
        }

        .observations-section p {
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
        }
    </style>
@endsection