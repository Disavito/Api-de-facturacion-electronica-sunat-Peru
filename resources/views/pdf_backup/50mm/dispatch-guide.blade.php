@extends('pdf.ticket.layout')

@section('content')
    <!-- Header -->
    <div class="header">
        <div class="company-name">{{ strtoupper($company->razon_social ?? 'EMPRESA') }}</div>
        <div class="company-info">
            @if($company->nombre_comercial)
                {{ $company->nombre_comercial }}<br>
            @endif
            RUC: {{ $company->ruc ?? '' }}<br>
            {{ $company->direccion ?? '' }}<br>
            @if($company->telefono)
                Tel: {{ $company->telefono }}<br>
            @endif
            @if($company->email)
                Email: {{ $company->email }}
            @endif
        </div>
    </div>

    <!-- Document Info -->
    <div class="document-info">
        <div>{{ $tipo_documento_nombre }}</div>
        <div>{{ $document->numero_completo }}</div>
        <div>{{ $fecha_emision }}</div>
    </div>

    <!-- Transport Info -->
    <div class="client-info">
        <div><strong>TRASLADO:</strong></div>
        <div><strong>Fecha:</strong> {{ $fecha_traslado }}</div>
        <div><strong>Motivo:</strong> {{ $motivo_traslado }}</div>
        <div><strong>Modalidad:</strong> {{ $modalidad_traslado }}</div>
        @if(isset($peso_total_formatted))
            <div><strong>Peso Total:</strong> {{ $peso_total_formatted }}</div>
        @endif
    </div>

    <!-- Destinatario Info -->
    <div class="client-info">
        <div><strong>DESTINATARIO:</strong></div>
        <div>{{ strtoupper($destinatario['razon_social'] ?? $destinatario['nombre'] ?? 'DESTINATARIO') }}</div>
        @if(isset($destinatario['numero_documento']))
            <div>{{ $destinatario['tipo_documento'] == '6' ? 'RUC' : 'DOC' }}: {{ $destinatario['numero_documento'] }}</div>
        @endif
        @if(isset($destinatario['direccion']) && $destinatario['direccion'])
            <div class="break-word">{{ $destinatario['direccion'] }}</div>
        @endif
    </div>

    <!-- Details -->
    <table class="details-table">
        <thead>
            <tr>
                <th>DESCRIPCIÓN</th>
                <th class="text-center">CANT</th>
                <th class="text-center">UNIDAD</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td class="break-word">
                        {{ strtoupper($detalle['descripcion'] ?? $detalle['nombre']) }}
                        @if(isset($detalle['codigo']) && $detalle['codigo'])
                            <br><small>Cod: {{ $detalle['codigo'] }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($detalle['cantidad'], 2) }}</td>
                    <td class="text-center">{{ $detalle['unidad'] ?? 'NIU' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Transport Details -->
    @if(isset($document->transportista_razon_social))
        <div class="client-info">
            <div><strong>TRANSPORTISTA:</strong></div>
            <div>{{ $document->transportista_razon_social }}</div>
            @if($document->transportista_ruc)
                <div>RUC: {{ $document->transportista_ruc }}</div>
            @endif
            @if($document->conductor_licencia)
                <div><strong>CONDUCTOR:</strong></div>
                <div>Lic: {{ $document->conductor_licencia }}</div>
            @endif
            @if($document->vehiculo_placa)
                <div><strong>VEHÍCULO:</strong> {{ $document->vehiculo_placa }}</div>
            @endif
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div class="footer-line">Autorizado mediante Resolución de Intendencia SUNAT</div>
        <div class="footer-line">Representación impresa de la {{ $tipo_documento_nombre ?? 'GUÍA DE REMISIÓN ELECTRÓNICA' }}</div>
        @if($company->website)
            <div class="footer-line">{{ $company->website }}</div>
        @endif
        @if(isset($document->codigo_hash))
            <div class="footer-line" style="font-size: {{ $format === '50mm' ? '4px' : '5px' }}; word-break: break-all;">Hash: {{ $document->codigo_hash }}</div>
        @endif
        <div class="footer-line"><strong>¡GRACIAS!</strong></div>
    </div>
@endsection