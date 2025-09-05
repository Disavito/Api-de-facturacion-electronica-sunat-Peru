<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $tipo_documento_nombre }}</title>
    <style>
        /* ================= BASE ================= */
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
        }

        /* ================= HEADER ================= */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .company-info {
            flex: 1;
            padding-right: 20px;
        }

        .company-info h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 5px 0;
            color: #1a365d;
        }

        .company-info .subtitle {
            font-size: 14px;
            margin: 0 0 10px 0;
            color: #666;
        }

        .company-details {
            font-size: 10px;
            line-height: 1.4;
        }

        .document-box {
            background: #f8f9fa;
            border: 2px solid #1a365d;
            padding: 15px;
            text-align: center;
            min-width: 200px;
            border-radius: 5px;
        }

        .document-type {
            font-size: 16px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 8px;
        }

        .document-number {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin: 5px 0;
        }

        .document-ruc {
            font-size: 12px;
            color: #666;
            margin-top: 8px;
        }

        /* ================= CLIENT INFO ================= */
        .client-section {
            margin: 20px 0;
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .client-title {
            font-weight: bold;
            font-size: 12px;
            color: #1a365d;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .client-data {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .client-field {
            display: flex;
            margin-bottom: 5px;
        }

        .client-label {
            font-weight: bold;
            min-width: 80px;
            color: #555;
        }

        .client-value {
            flex: 1;
        }

        /* ================= DOCUMENT DETAILS ================= */
        .document-details {
            margin: 15px 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .detail-field {
            display: flex;
            align-items: center;
        }

        .detail-label {
            font-weight: bold;
            min-width: 100px;
            color: #555;
        }

        /* ================= TABLE ================= */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 10px;
        }

        .items-table th {
            background: #1a365d;
            color: white;
            padding: 8px 5px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
        }

        .items-table td {
            padding: 6px 5px;
            border: 1px solid #ccc;
            text-align: center;
            vertical-align: top;
        }

        .items-table .text-left {
            text-align: left;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        /* ================= TOTALS ================= */
        .totals-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .totals-left {
            flex: 1;
            padding-right: 20px;
        }

        .totals-right {
            min-width: 300px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .totals-table td {
            padding: 5px 10px;
            border: 1px solid #ccc;
        }

        .totals-table .label {
            background: #f0f0f0;
            font-weight: bold;
            text-align: right;
        }

        .totals-table .value {
            text-align: right;
            font-weight: bold;
        }

        .total-final {
            background: #1a365d !important;
            color: white !important;
            font-size: 12px;
            font-weight: bold;
        }

        /* ================= FOOTER ================= */
        .footer-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .qr-section {
            text-align: center;
            min-width: 150px;
        }

        .qr-code img {
            width: 120px;
            height: 120px;
        }

        .qr-info {
            font-size: 9px;
            color: #666;
            margin-top: 5px;
        }

        .additional-info {
            flex: 1;
            padding-left: 20px;
            font-size: 9px;
            color: #666;
        }

        .hash-info {
            margin-top: 10px;
            padding: 8px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            font-size: 8px;
            word-break: break-all;
        }

        /* ================= RESPONSIVE ================= */
        @media print {
            body { margin: 0; }
            .container { padding: 0; }
        }

        /* ================= UTILITIES ================= */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .text-upper { text-transform: uppercase; }
        .mb-10 { margin-bottom: 10px; }
        .mt-10 { margin-top: 10px; }

        /* ================= SPECIAL FIELDS ================= */
        .observaciones {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            font-size: 10px;
        }

        .leyendas {
            margin: 10px 0;
            font-size: 9px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <div class="company-info">
                <h1>{{ $company->razon_social }}</h1>
                @if($company->nombre_comercial && $company->nombre_comercial != $company->razon_social)
                    <div class="subtitle">{{ $company->nombre_comercial }}</div>
                @endif
                
                <div class="company-details">
                    <div><strong>Dirección:</strong> {{ $company->direccion }}</div>
                    @if($company->distrito || $company->provincia || $company->departamento)
                        <div>
                            {{ $company->distrito ? $company->distrito . ', ' : '' }}
                            {{ $company->provincia ? $company->provincia . ', ' : '' }}
                            {{ $company->departamento }}
                        </div>
                    @endif
                    
                    @if($company->telefono)
                        <div><strong>Teléfono:</strong> {{ $company->telefono }}</div>
                    @endif
                    
                    @if($company->email)
                        <div><strong>Email:</strong> {{ $company->email }}</div>
                    @endif
                    
                    @if($company->web)
                        <div><strong>Web:</strong> {{ $company->web }}</div>
                    @endif
                </div>
            </div>
            
            <div class="document-box">
                <div class="document-type">{{ $tipo_documento_nombre }}</div>
                <div class="document-number">{{ $document->serie }}-{{ str_pad($document->correlativo, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="document-ruc">RUC: {{ $company->ruc }}</div>
            </div>
        </div>

        <!-- CLIENT INFORMATION -->
        <div class="client-section">
            <div class="client-title">DATOS DEL CLIENTE</div>
            <div class="client-data">
                <div class="client-field">
                    <span class="client-label">Señor(es):</span>
                    <span class="client-value">{{ $client['razon_social'] }}</span>
                </div>
                <div class="client-field">
                    <span class="client-label">{{ $client['tipo_documento'] == '6' ? 'RUC' : 'DNI' }}:</span>
                    <span class="client-value">{{ $client['numero_documento'] }}</span>
                </div>
                @if(!empty($client['direccion']))
                <div class="client-field">
                    <span class="client-label">Dirección:</span>
                    <span class="client-value">{{ $client['direccion'] }}</span>
                </div>
                @endif
                @if(!empty($client['telefono']))
                <div class="client-field">
                    <span class="client-label">Teléfono:</span>
                    <span class="client-value">{{ $client['telefono'] }}</span>
                </div>
                @endif
                @if(!empty($client['email']))
                <div class="client-field">
                    <span class="client-label">Email:</span>
                    <span class="client-value">{{ $client['email'] }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- DOCUMENT DETAILS -->
        <div class="document-details">
            <div class="detail-field">
                <span class="detail-label">Fecha Emisión:</span>
                <span>{{ $fecha_emision }}</span>
            </div>
            @if($fecha_vencimiento)
            <div class="detail-field">
                <span class="detail-label">Fecha Vencimiento:</span>
                <span>{{ $fecha_vencimiento }}</span>
            </div>
            @endif
            <div class="detail-field">
                <span class="detail-label">Moneda:</span>
                <span>{{ $totales['moneda_nombre'] }}</span>
            </div>
        </div>

        <!-- ITEMS TABLE -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 8%">CANT.</th>
                    <th style="width: 10%">UNIDAD</th>
                    <th style="width: 15%">CÓDIGO</th>
                    <th style="width: 37%">DESCRIPCIÓN</th>
                    <th style="width: 10%">V.UNIT</th>
                    <th style="width: 10%">V.VENTA</th>
                    <th style="width: 10%">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detalles as $detalle)
                <tr>
                    <td class="text-center">{{ $detalle['cantidad'] ?? 0 }}</td>
                    <td class="text-center">{{ $detalle['unidad'] ?? 'NIU' }}</td>
                    <td class="text-left">{{ $detalle['codigo'] ?? '' }}</td>
                    <td class="text-left">{{ $detalle['descripcion'] ?? '' }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_valor_venta'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format(($detalle['mto_valor_venta'] ?? 0) + ($detalle['igv'] ?? 0), 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No hay items registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- TOTALS SECTION -->
        <div class="totals-section">
            <div class="totals-left">
                <div style="font-weight: bold; margin-bottom: 10px;">SON: {{ strtoupper($total_en_letras) }}</div>
                
                @if(!empty($document->observaciones))
                <div class="observaciones">
                    <strong>Observaciones:</strong><br>
                    {{ $document->observaciones }}
                </div>
                @endif
                
                @if(!empty($document->leyendas))
                <div class="leyendas">
                    <strong>Leyendas:</strong><br>
                    @php
                        $leyendas = is_array($document->leyendas) ? $document->leyendas : json_decode($document->leyendas, true);
                        $leyendas = $leyendas ?? [];
                    @endphp
                    @foreach($leyendas as $leyenda)
                        • {{ $leyenda['value'] ?? '' }}<br>
                    @endforeach
                </div>
                @endif
            </div>
            
            <div class="totals-right">
                <table class="totals-table">
                    <tr>
                        <td class="label">OP. GRAVADAS:</td>
                        <td class="value">{{ $totales['moneda'] }} {{ $totales['subtotal_formatted'] }}</td>
                    </tr>
                    @if($document->mto_oper_exoneradas > 0)
                    <tr>
                        <td class="label">OP. EXONERADAS:</td>
                        <td class="value">{{ $totales['moneda'] }} {{ number_format($document->mto_oper_exoneradas, 2) }}</td>
                    </tr>
                    @endif
                    @if($document->mto_oper_inafectas > 0)
                    <tr>
                        <td class="label">OP. INAFECTAS:</td>
                        <td class="value">{{ $totales['moneda'] }} {{ number_format($document->mto_oper_inafectas, 2) }}</td>
                    </tr>
                    @endif
                    @if($document->mto_icbper > 0)
                    <tr>
                        <td class="label">ICBPER:</td>
                        <td class="value">{{ $totales['moneda'] }} {{ number_format($document->mto_icbper, 2) }}</td>
                    </tr>
                    @endif
                    @if($document->mto_isc > 0)
                    <tr>
                        <td class="label">ISC:</td>
                        <td class="value">{{ $totales['moneda'] }} {{ number_format($document->mto_isc, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="label">IGV (18%):</td>
                        <td class="value">{{ $totales['moneda'] }} {{ $totales['igv_formatted'] }}</td>
                    </tr>
                    <tr class="total-final">
                        <td class="label">IMPORTE TOTAL:</td>
                        <td class="value">{{ $totales['moneda'] }} {{ $totales['total_formatted'] }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer-section">
            <div class="qr-section">
                <div class="qr-code">
                    <img src="{{ $qr_code }}" alt="Código QR">
                </div>
                <div class="qr-info">
                    Representación impresa del<br>
                    Comprobante de Pago Electrónico<br>
                    Consulte en www.sunat.gob.pe
                </div>
            </div>
            
            <div class="additional-info">
                <div><strong>Autorizado mediante Resolución de Intendencia N°</strong></div>
                <div>034-005-0000971/SUNAT, de fecha 15/03/2016.</div>
                
                @if($hash)
                <div class="hash-info">
                    <strong>Hash (Resumen Digital):</strong><br>
                    {{ $hash }}
                </div>
                @endif
                
                <div style="margin-top: 15px; text-align: center;">
                    <em>Este documento fue generado electrónicamente y tiene validez legal</em>
                </div>
            </div>
        </div>
    </div>
</body>
</html>