<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $tipo_documento_nombre }}</title>
    <style>
        /* ================= BASE ================= */
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 5px;
            color: #333;
            width: 72mm;
        }

        .container {
            width: 100%;
            padding: 0;
        }

        /* ================= HEADER ================= */
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
        }

        .company-name {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .company-details {
            font-size: 8px;
            line-height: 1.2;
            margin-bottom: 5px;
        }

        .document-info {
            font-size: 10px;
            font-weight: bold;
            margin: 5px 0;
        }

        /* ================= CLIENT INFO ================= */
        .client-section {
            margin: 8px 0;
            font-size: 8px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 5px;
        }

        .client-row {
            margin-bottom: 2px;
        }

        .client-label {
            font-weight: bold;
            display: inline-block;
            min-width: 25mm;
        }

        /* ================= DOCUMENT DETAILS ================= */
        .document-details {
            margin: 5px 0;
            font-size: 8px;
        }

        .detail-row {
            margin-bottom: 2px;
        }

        /* ================= TABLE ================= */
        .items-section {
            margin: 8px 0;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }

        .items-header {
            font-size: 8px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 3px;
        }

        .item {
            font-size: 8px;
            margin-bottom: 3px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 2px;
        }

        .item-desc {
            font-weight: bold;
            margin-bottom: 1px;
        }

        .item-details {
            display: flex;
            justify-content: space-between;
        }

        /* ================= TOTALS ================= */
        .totals-section {
            margin: 8px 0;
            font-size: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1px;
        }

        .total-row.final {
            font-weight: bold;
            font-size: 9px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 2px 0;
            margin-top: 3px;
        }

        /* ================= FOOTER ================= */
        .footer-section {
            margin-top: 8px;
            text-align: center;
            font-size: 7px;
        }

        .qr-section {
            margin: 8px 0;
        }

        .qr-code img {
            width: 60px;
            height: 60px;
        }

        .qr-info {
            margin-top: 3px;
            line-height: 1.2;
        }

        .total-words {
            margin: 5px 0;
            font-size: 8px;
            text-align: left;
            font-weight: bold;
        }

        /* ================= UTILITIES ================= */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .text-upper { text-transform: uppercase; }
        .dashed-line {
            border-bottom: 1px dashed #000;
            margin: 5px 0;
        }

        @media print {
            body { margin: 0; padding: 2px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <div class="company-name">{{ $company->razon_social }}</div>
            @if($company->nombre_comercial && $company->nombre_comercial != $company->razon_social)
                <div style="font-size: 10px;">{{ $company->nombre_comercial }}</div>
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
                <span class="client-label">Dirección:</span> {{ $client['direccion'] }}
            </div>
            @endif
        </div>

        <!-- DOCUMENT DETAILS -->
        <div class="document-details">
            <div class="detail-row">
                <span class="text-bold">Fecha:</span> {{ $fecha_emision }}
            </div>
            <div class="detail-row">
                <span class="text-bold">Moneda:</span> {{ $totales['moneda_nombre'] }}
            </div>
        </div>

        <!-- ITEMS -->
        <div class="items-section">
            <div class="items-header">DETALLE</div>
            @forelse($detalles as $detalle)
            <div class="item">
                <div class="item-desc">{{ $detalle['descripcion'] ?? '' }}</div>
                <div class="item-details">
                    <span>{{ $detalle['cantidad'] ?? 0 }} {{ $detalle['unidad'] ?? 'NIU' }}</span>
                    <span>{{ number_format($detalle['mto_valor_unitario'] ?? 0, 2) }}</span>
                    <span>{{ number_format(($detalle['mto_valor_venta'] ?? 0) + ($detalle['igv'] ?? 0), 2) }}</span>
                </div>
            </div>
            @empty
            <div class="item">No hay items</div>
            @endforelse
        </div>

        <!-- TOTALS -->
        <div class="totals-section">
            <div class="total-row">
                <span>Op. Gravadas:</span>
                <span>{{ $totales['subtotal_formatted'] }}</span>
            </div>
            @if($document->mto_oper_exoneradas > 0)
            <div class="total-row">
                <span>Op. Exoneradas:</span>
                <span>{{ number_format($document->mto_oper_exoneradas, 2) }}</span>
            </div>
            @endif
            @if($document->mto_icbper > 0)
            <div class="total-row">
                <span>ICBPER:</span>
                <span>{{ number_format($document->mto_icbper, 2) }}</span>
            </div>
            @endif
            <div class="total-row">
                <span>IGV (18%):</span>
                <span>{{ $totales['igv_formatted'] }}</span>
            </div>
            <div class="total-row final">
                <span>TOTAL {{ $totales['moneda'] }}:</span>
                <span>{{ $totales['total_formatted'] }}</span>
            </div>
        </div>

        <!-- TOTAL EN LETRAS -->
        <div class="total-words">
            SON: {{ strtoupper($total_en_letras) }}
        </div>

        <!-- QR AND FOOTER -->
        <div class="footer-section">
            <div class="qr-section">
                <img src="{{ $qr_code }}" alt="QR">
                <div class="qr-info">
                    Representación impresa del<br>
                    Comprobante de Pago Electrónico<br>
                    Consulte en www.sunat.gob.pe
                </div>
            </div>
            
            <div class="dashed-line"></div>
            
            <div style="margin-top: 5px;">
                Autorizado mediante Resolución<br>
                de Intendencia N° 034-005-0000971/SUNAT
            </div>
            
            @if($hash)
            <div style="margin-top: 5px; font-size: 6px; word-break: break-all;">
                Hash: {{ $hash }}
            </div>
            @endif
            
            <div style="margin-top: 5px;">
                <em>Gracias por su compra</em>
            </div>
        </div>
    </div>
</body>
</html>