<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $tipo_documento_nombre }}</title>
    <style>
        /* ================= BASE ================= */
        body {
            font-family: Arial, sans-serif;
            font-size: 7px;
            margin: 0;
            padding: 3px;
            color: #333;
            width: 46mm;
        }

        .container {
            width: 100%;
            padding: 0;
        }

        /* ================= HEADER ================= */
        .header {
            text-align: center;
            margin-bottom: 6px;
            border-bottom: 1px dashed #000;
            padding-bottom: 4px;
        }

        .company-name {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .company-details {
            font-size: 6px;
            line-height: 1.1;
            margin-bottom: 3px;
        }

        .document-info {
            font-size: 7px;
            font-weight: bold;
            margin: 3px 0;
        }

        /* ================= CLIENT INFO ================= */
        .client-section {
            margin: 4px 0;
            font-size: 6px;
            border-bottom: 1px dashed #000;
            padding-bottom: 4px;
        }

        .client-row {
            margin-bottom: 1px;
            word-wrap: break-word;
        }

        .client-label {
            font-weight: bold;
        }

        /* ================= DOCUMENT DETAILS ================= */
        .document-details {
            margin: 4px 0;
            font-size: 6px;
            border-bottom: 1px dashed #000;
            padding-bottom: 4px;
        }

        .detail-row {
            margin-bottom: 1px;
        }

        /* ================= TABLE ================= */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0;
            font-size: 6px;
        }

        .items-table th {
            background: #f0f0f0;
            font-weight: bold;
            padding: 2px 1px;
            border: 1px solid #000;
            text-align: center;
        }

        .items-table td {
            padding: 2px 1px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .text-left { text-align: left; }
        .text-right { text-align: right; }

        /* ================= TOTALS ================= */
        .totals-section {
            margin-top: 4px;
            font-size: 6px;
            border-top: 1px dashed #000;
            padding-top: 4px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1px;
        }

        .total-row .label {
            font-weight: bold;
        }

        .total-final {
            font-size: 7px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 2px;
            margin-top: 2px;
        }

        /* ================= FOOTER ================= */
        .footer-section {
            margin-top: 6px;
            text-align: center;
            font-size: 5px;
            border-top: 1px dashed #000;
            padding-top: 4px;
        }

        .qr-code img {
            width: 40px;
            height: 40px;
            margin: 2px 0;
        }

        .en-letras {
            font-size: 6px;
            font-weight: bold;
            text-align: center;
            margin: 4px 0;
            word-wrap: break-word;
        }

        /* ================= UTILITIES ================= */
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .text-upper { text-transform: uppercase; }
        .dashed-line {
            border-bottom: 1px dashed #000;
            margin: 3px 0;
        }

        @media print {
            body { margin: 0; padding: 1px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <div class="company-name">{{ $company->razon_social }}</div>
            @if($company->nombre_comercial && $company->nombre_comercial != $company->razon_social)
                <div style="font-size: 7px;">{{ $company->nombre_comercial }}</div>
            @endif
            
            <div class="company-details">
                <div>{{ $company->direccion }}</div>
                @if($company->distrito || $company->provincia)
                    <div>{{ $company->distrito }}{{ $company->provincia ? ', ' . $company->provincia : '' }}</div>
                @endif
                
                @if($company->telefono)
                    <div>Tel: {{ $company->telefono }}</div>
                @endif
                
                @if($company->email)
                    <div>{{ $company->email }}</div>
                @endif
            </div>
            
            <div class="document-info">
                <div>{{ $tipo_documento_nombre }}</div>
                <div>{{ $document->serie }}-{{ str_pad($document->correlativo, 6, '0', STR_PAD_LEFT) }}</div>
                <div>RUC: {{ $company->ruc }}</div>
            </div>
        </div>

        <!-- CLIENT INFORMATION -->
        <div class="client-section">
            <div class="client-row">
                <span class="client-label">Cliente:</span> {{ $client['razon_social'] }}
            </div>
            <div class="client-row">
                <span class="client-label">{{ $client['tipo_documento'] == '6' ? 'RUC' : 'DNI' }}:</span> {{ $client['numero_documento'] }}
            </div>
            @if(!empty($client['direccion']))
            <div class="client-row">
                <span class="client-label">Dir:</span> {{ $client['direccion'] }}
            </div>
            @endif
        </div>

        <!-- DOCUMENT DETAILS -->
        <div class="document-details">
            <div class="detail-row">
                <span class="client-label">Fecha:</span> {{ $fecha_emision }}
            </div>
            @if($fecha_vencimiento)
            <div class="detail-row">
                <span class="client-label">Venc:</span> {{ $fecha_vencimiento }}
            </div>
            @endif
            <div class="detail-row">
                <span class="client-label">Moneda:</span> {{ $totales['moneda_nombre'] }}
            </div>
        </div>

        <!-- ITEMS TABLE -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>CANT</th>
                    <th>DESCRIPCIÓN</th>
                    <th>P.U</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detalles as $detalle)
                <tr>
                    <td class="text-center">{{ number_format($detalle['cantidad'] ?? 0, 0) }}</td>
                    <td class="text-left">{{ $detalle['descripcion'] ?? '' }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_valor_venta'] ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Sin items</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- SON EN LETRAS -->
        <div class="en-letras">
            SON: {{ strtoupper($total_en_letras) }} {{ strtoupper($totales['moneda_nombre'] ?? 'SOLES') }}
        </div>

        <!-- TOTALS -->
        <div class="totals-section">
            <div class="total-row">
                <span class="label">Op. Gravadas:</span>
                <span>{{ $totales['moneda'] }} {{ $totales['subtotal_formatted'] }}</span>
            </div>
            
            @if($document->mto_oper_exoneradas > 0)
            <div class="total-row">
                <span class="label">Op. Exoneradas:</span>
                <span>{{ $totales['moneda'] }} {{ number_format($document->mto_oper_exoneradas, 2) }}</span>
            </div>
            @endif
            
            @if($document->mto_oper_inafectas > 0)
            <div class="total-row">
                <span class="label">Op. Inafectas:</span>
                <span>{{ $totales['moneda'] }} {{ number_format($document->mto_oper_inafectas, 2) }}</span>
            </div>
            @endif
            
            <div class="total-row">
                <span class="label">IGV (18%):</span>
                <span>{{ $totales['moneda'] }} {{ $totales['igv_formatted'] }}</span>
            </div>
            
            <div class="total-row total-final">
                <span class="label">TOTAL:</span>
                <span>{{ $totales['moneda'] }} {{ $totales['total_formatted'] }}</span>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer-section">
            <div class="qr-code">
                <img src="{{ $qr_code }}" alt="Código QR">
            </div>
            
            <div style="margin-top: 2px;">
                Representación impresa del<br>
                {{ $tipo_documento_nombre ?? 'COMPROBANTE ELECTRÓNICO' }}
            </div>
            
            @if(!empty($document->observaciones))
            <div style="margin-top: 3px; font-size: 5px;">
                <strong>Obs:</strong> {{ $document->observaciones }}
            </div>
            @endif
            
            @if(!empty($document->leyendas))
            <div style="margin-top: 2px; font-size: 5px;">
                @php
                    $leyendas = is_array($document->leyendas) ? $document->leyendas : json_decode($document->leyendas, true);
                    $leyendas = $leyendas ?? [];
                @endphp
                @foreach($leyendas as $leyenda)
                • {{ $leyenda['value'] ?? '' }}<br>
                @endforeach
            </div>
            @endif
            
            @if($hash)
            <div style="margin-top: 2px; font-size: 4px; word-break: break-all;">
                Hash: {{ substr($hash, 0, 10) }}...
            </div>
            @endif
        </div>
    </div>
</body>
</html>