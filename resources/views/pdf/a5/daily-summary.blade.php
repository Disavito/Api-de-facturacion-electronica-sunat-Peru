@extends('pdf.a5.layout')

@section('title', 'Resumen Diario de Boletas - A5')

@section('content')
    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <div class="company-name">{{ $company->razon_social ?? 'EMPRESA' }}</div>
            <div class="company-address">RUC: {{ $company->ruc ?? '' }}</div>
            <div class="company-address">{{ $company->direccion ?? '' }}</div>
            @if($company->telefono ?? null)
                <div class="company-address">Tel: {{ $company->telefono }}</div>
            @endif
            @if($company->email ?? null)
                <div class="company-address">Email: {{ $company->email }}</div>
            @endif
        </div>
        
        <div class="document-box">
            <div class="document-type">{{ $tipo_documento_nombre ?? 'RESUMEN DIARIO' }}</div>
            <div class="document-number">{{ $document->numero_completo ?? '' }}</div>
        </div>
    </div>

    <!-- Document Info -->
    <div class="client-section">
        <div class="section-title">INFORMACIÓN DEL RESUMEN</div>
        <div class="client-row">
            <div class="client-label">Fecha Emisión:</div>
            <div class="client-value">{{ $fecha_emision ?? '' }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">Fecha Referencia:</div>
            <div class="client-value">{{ $fecha_referencia ?? '' }}</div>
        </div>
        @if(isset($document->estado_sunat))
        <div class="client-row">
            <div class="client-label">Estado SUNAT:</div>
            <div class="client-value">{{ $document->estado_sunat }}</div>
        </div>
        @endif
        @if(isset($document->ticket))
        <div class="client-row">
            <div class="client-label">Ticket:</div>
            <div class="client-value">{{ $document->ticket }}</div>
        </div>
        @endif
    </div>

    <!-- Summary Details -->
    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 20mm">TIPO DOC</th>
                <th style="width: 25mm">SERIE</th>
                <th style="width: 20mm">DESDE</th>
                <th style="width: 20mm">HASTA</th>
                <th style="width: 15mm">CANT.</th>
                <th style="width: 25mm">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @if(is_array($detalles ?? []) && count($detalles) > 0)
                @foreach($detalles as $detalle)
                <tr>
                    <td class="text-center">{{ $detalle['tipo_documento'] == '03' ? 'BOLETA' : 'DOC' }}</td>
                    <td class="text-center">{{ $detalle['serie'] ?? '' }}</td>
                    <td class="text-center">{{ $detalle['correlativo_inicio'] ?? '' }}</td>
                    <td class="text-center">{{ $detalle['correlativo_fin'] ?? $detalle['correlativo_inicio'] ?? '' }}</td>
                    <td class="text-center">{{ $detalle['cantidad'] ?? 1 }}</td>
                    <td class="text-right">S/ {{ number_format($detalle['mto_imp_venta'] ?? 0, 2) }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No hay detalles disponibles</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals-section">
        <table class="totals-table">
            <tr>
                <td class="label">TOTAL GRAVADA:</td>
                <td class="value">S/ {{ $totales['total_gravada_formatted'] ?? '0.00' }}</td>
            </tr>
            <tr>
                <td class="label">TOTAL IGV:</td>
                <td class="value">S/ {{ $totales['total_igv_formatted'] ?? '0.00' }}</td>
            </tr>
            <tr>
                <td class="label bold">TOTAL VENTA:</td>
                <td class="value bold">S/ {{ $totales['total_venta_formatted'] ?? '0.00' }}</td>
            </tr>
        </table>
    </div>

    <!-- Amount in Words -->
    <div class="amount-words">
        <strong>SON: {{ (new \App\Services\PdfService())->numeroALetras($totales['total_venta'] ?? 0) }} {{ $totales['moneda_nombre'] ?? 'SOLES' }}</strong>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="small">
            <strong>OBSERVACIONES:</strong><br>
            - Este resumen diario se encuentra almacenado electrónicamente en SUNAT.<br>
            - Para verificar su autenticidad ingrese a www.sunat.gob.pe<br>
            - Comprobantes incluidos en este resumen diario<br>
            @if(($document->observaciones ?? null))
            - {{ $document->observaciones }}<br>
            @endif
        </div>
        
        @if(($document->codigo_hash ?? null))
        <div class="qr-code mt-10">
            <div class="small">Código Hash: {{ $document->codigo_hash }}</div>
        </div>
        @endif
    </div>
@endsection