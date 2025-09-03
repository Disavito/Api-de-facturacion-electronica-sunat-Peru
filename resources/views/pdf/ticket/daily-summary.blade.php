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
        <div>Fecha Emisión: {{ $fecha_emision }}</div>
        <div>Fecha Resumen: {{ $fecha_referencia }}</div>
    </div>

    <!-- Summary Details -->
    <table class="details-table">
        <thead>
            <tr>
                <th>DOCUMENTO</th>
                <th class="text-center">CANT</th>
                <th class="text-right">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td class="break-word">
                        {{ $detalle['tipo_documento'] == '03' ? 'BOLETA' : 'DOC' }}
                        {{ $detalle['serie'] }}-{{ $detalle['correlativo_inicio'] }}
                        @if($detalle['correlativo_inicio'] != $detalle['correlativo_fin'])
                            al {{ $detalle['correlativo_fin'] }}
                        @endif
                    </td>
                    <td class="text-center">{{ $detalle['cantidad'] ?? 1 }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_imp_venta'] ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        @if($totales['total_gravada'] > 0)
            <div class="total-row">
                <span>TOTAL GRAVADA:</span>
                <span>S/ {{ $totales['total_gravada_formatted'] }}</span>
            </div>
        @endif
        @if($totales['total_igv'] > 0)
            <div class="total-row">
                <span>TOTAL IGV:</span>
                <span>S/ {{ $totales['total_igv_formatted'] }}</span>
            </div>
        @endif
        <div class="total-row total-final">
            <span>TOTAL VENTA:</span>
            <span>S/ {{ $totales['total_venta_formatted'] }}</span>
        </div>
    </div>

    <!-- Status Info -->
    @if(isset($document->estado_sunat))
        <div class="client-info">
            <div><strong>ESTADO SUNAT:</strong> {{ $document->estado_sunat }}</div>
            @if($document->ticket)
                <div><strong>TICKET:</strong> {{ $document->ticket }}</div>
            @endif
        </div>
    @endif

    <!-- QR Code Section -->
    @if($format !== '50mm')
        <div class="qr-section">
            <div class="qr-code">
                @if(isset($document->codigo_hash))
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($document->codigo_hash) }}" alt="Código QR">
                @else
                    <div style="font-size: {{ $format === '50mm' ? '6px' : '8px' }}; color: #6c757d;">QR CODE</div>
                @endif
            </div>
            <div class="qr-text">
                Consulte la validez del comprobante en:<br>
                <strong>www.sunat.gob.pe</strong>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div class="footer-line">Autorizado mediante Resolución de Intendencia SUNAT</div>
        <div class="footer-line">Representación impresa del {{ $tipo_documento_nombre ?? 'RESUMEN DIARIO' }}</div>
        @if($company->website)
            <div class="footer-line">{{ $company->website }}</div>
        @endif
        @if(isset($document->codigo_hash))
            <div class="footer-line" style="font-size: {{ $format === '50mm' ? '4px' : '5px' }}; word-break: break-all;">Hash: {{ $document->codigo_hash }}</div>
        @endif
        <div class="footer-line"><strong>RESUMEN PROCESADO</strong></div>
    </div>
@endsection