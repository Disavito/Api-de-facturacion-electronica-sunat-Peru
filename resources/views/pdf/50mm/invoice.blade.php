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

    <!-- Client Info -->
    <div class="client-info">
        <div><strong>CLIENTE:</strong></div>
        <div>{{ strtoupper($client['razon_social'] ?? $client['nombre'] ?? 'CLIENTE') }}</div>
        @if(isset($client['numero_documento']))
            <div>{{ $client['tipo_documento'] == '6' ? 'RUC' : ($client['tipo_documento'] == '1' ? 'DNI' : 'DOC') }}: {{ $client['numero_documento'] }}</div>
        @endif
        @if(isset($client['direccion']) && $client['direccion'])
            <div class="break-word">{{ $client['direccion'] }}</div>
        @endif
    </div>

    <!-- Details -->
    <table class="details-table">
        <thead>
            <tr>
                <th>DESCRIPCIÓN</th>
                <th class="text-center">CANT</th>
                <th class="text-right">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td class="break-word">
                        {{ strtoupper($detalle['descripcion']) }}
                        @if(isset($detalle['codigo']) && $detalle['codigo'])
                            <br><small>Cod: {{ $detalle['codigo'] }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($detalle['cantidad'], 0) }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_valor_venta'] ?? ($detalle['cantidad'] * $detalle['mto_valor_unitario']), 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        @if($totales['subtotal'] > 0)
            <div class="total-row">
                <span>SUB TOTAL:</span>
                <span>S/ {{ $totales['subtotal_formatted'] }}</span>
            </div>
        @endif
        @if($totales['igv'] > 0)
            <div class="total-row">
                <span>IGV (18%):</span>
                <span>S/ {{ $totales['igv_formatted'] }}</span>
            </div>
        @endif
        <div class="total-row total-final">
            <span>TOTAL:</span>
            <span>S/ {{ $totales['total_formatted'] }}</span>
        </div>
    </div>

    <!-- Payment Info -->
    @if(isset($document->forma_pago_tipo))
        <div class="client-info">
            <div><strong>FORMA DE PAGO:</strong> {{ $document->forma_pago_tipo }}</div>
            @if($document->forma_pago_tipo === 'Credito' && $document->fecha_vencimiento)
                <div><strong>VENCIMIENTO:</strong> {{ $document->fecha_vencimiento->format('d/m/Y') }}</div>
            @endif
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div class="footer-line">Autorizado mediante Resolución de Intendencia SUNAT</div>
        <div class="footer-line">Representación impresa de la {{ $tipo_documento_nombre ?? 'FACTURA ELECTRÓNICA' }}</div>
        @if($company->website)
            <div class="footer-line">{{ $company->website }}</div>
        @endif
        @if(isset($document->codigo_hash))
            <div class="footer-line" style="font-size: {{ $format === '50mm' ? '4px' : '5px' }}; word-break: break-all;">Hash: {{ $document->codigo_hash }}</div>
        @endif
        <div class="footer-line"><strong>¡GRACIAS POR SU COMPRA!</strong></div>
    </div>
@endsection