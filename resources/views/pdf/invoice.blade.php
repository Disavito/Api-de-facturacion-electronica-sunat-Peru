@extends('pdf.layout')

@section('title', 'Factura Electrónica')

@section('content')
    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <div class="company-name">{{ $company->razon_social }}</div>
            <div class="company-address">RUC: {{ $company->ruc }}</div>
            <div class="company-address">{{ $company->direccion }}</div>
            @if($company->telefono)
                <div class="company-address">Tel: {{ $company->telefono }}</div>
            @endif
            @if($company->email)
                <div class="company-address">Email: {{ $company->email }}</div>
            @endif
        </div>
        
        <div class="document-box">
            <div class="document-type">{{ $tipo_documento_nombre }}</div>
            <div class="document-number">{{ $document->numero_completo }}</div>
        </div>
    </div>

    <!-- Client Information -->
    <div class="client-section">
        <div class="section-title">DATOS DEL CLIENTE</div>
        <div class="client-row">
            <div class="client-label">Señor(es):</div>
            <div class="client-value">{{ $client['razon_social'] }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">{{ $client['tipo_documento'] == '6' ? 'RUC:' : 'DNI:' }}</div>
            <div class="client-value">{{ $client['numero_documento'] }}</div>
        </div>
        @if(!empty($client['direccion']))
        <div class="client-row">
            <div class="client-label">Dirección:</div>
            <div class="client-value">{{ $client['direccion'] }}</div>
        </div>
        @endif
        <div class="client-row">
            <div class="client-label">Fecha Emisión:</div>
            <div class="client-value">{{ $fecha_emision }}</div>
        </div>
        @if($fecha_vencimiento)
        <div class="client-row">
            <div class="client-label">Fecha Vencto:</div>
            <div class="client-value">{{ $fecha_vencimiento }}</div>
        </div>
        @endif
        <div class="client-row">
            <div class="client-label">Moneda:</div>
            <div class="client-value">{{ $totales['moneda_nombre'] }}</div>
        </div>
    </div>

    <!-- Details Table -->
    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 60px">CANT.</th>
                <th style="width: 80px">UNIDAD</th>
                <th style="width: 100px">CÓDIGO</th>
                <th>DESCRIPCIÓN</th>
                <th style="width: 80px">P.UNIT</th>
                <th style="width: 80px">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
            <tr>
                <td class="text-center">{{ number_format($detalle['cantidad'], 3) }}</td>
                <td class="text-center">{{ $detalle['unidad'] }}</td>
                <td class="text-center">{{ $detalle['codigo'] }}</td>
                <td class="text-left">{{ $detalle['descripcion'] }}</td>
                <td class="text-right">{{ number_format($detalle['mto_valor_unitario'], 2) }}</td>
                <td class="text-right">{{ number_format($detalle['cantidad'] * $detalle['mto_valor_unitario'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals-section">
        <table class="totals-table">
            <tr>
                <td class="label">SUB TOTAL:</td>
                <td class="value">{{ $totales['moneda'] }} {{ $totales['subtotal_formatted'] }}</td>
            </tr>
            <tr>
                <td class="label">IGV (18%):</td>
                <td class="value">{{ $totales['moneda'] }} {{ $totales['igv_formatted'] }}</td>
            </tr>
            <tr>
                <td class="label bold">TOTAL:</td>
                <td class="value bold">{{ $totales['moneda'] }} {{ $totales['total_formatted'] }}</td>
            </tr>
        </table>
    </div>

    <!-- Amount in Words -->
    <div class="amount-words">
        <strong>SON: {{ (new \App\Services\PdfService())->numeroALetras($totales['total']) }} {{ $totales['moneda_nombre'] }}</strong>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="small">
            <strong>OBSERVACIONES:</strong><br>
            - Esta factura se encuentra almacenada electrónicamente en SUNAT.<br>
            - Para verificar su autenticidad ingrese a www.sunat.gob.pe<br>
            @if($document->observaciones)
            - {{ $document->observaciones }}<br>
            @endif
        </div>
        
        @if($document->codigo_hash)
        <div class="qr-code mt-10">
            <div class="small">Código Hash: {{ $document->codigo_hash }}</div>
        </div>
        @endif
    </div>
@endsection