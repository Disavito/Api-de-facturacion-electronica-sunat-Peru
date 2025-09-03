<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Electrónica</title>
    <style>
        /* ================= BASE ================= */
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            width: 100%;
            max-width: 190mm;
            margin: 0 auto;
            padding: 10mm;
            box-sizing: border-box;
            background-color: white;
            border: 2px solid #000;
            border-radius: 10px;
            min-height: 250mm;
        }

        /* ================= QR INFO CONTAINER ================= */
        .qr-info-container {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 5px;
        }

        .qr-section {
            flex-shrink: 0;
            text-align: center;
        }

        .qr-code img {
            width: 80px;
            height: 80px;
            display: block;
            border: 1px solid #ccc;
        }

        .footer-info {
            font-size: 9px;
            text-align: left;
            flex: 1;
            line-height: 1.3;
        }

        /* ================= PRINT ================= */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: white;
            }

            .container {
                border: 1px solid #000;
                padding: 8mm;
                width: 100%;
                max-width: none;
                page-break-inside: avoid;
                background-color: white;
                min-height: auto;
                max-height: 270mm;
                overflow: hidden;
            }
        }

        @page {
            size: A4 portrait;
            margin: 12mm;
        }
    </style>
</head>
<body>
    <div class="container">
    <!-- Header Section -->
    <div class="header invoice-header">
        <div class="header-left">
            <div class="company-logo">
                LOGO
            </div>
            <div class="company-info">
                <div class="company-name">{{ $company->razon_social ?? 'RAZÓN SOCIAL DE LA EMPRESA' }}</div>
                <div class="company-details"><strong>Dirección:</strong> {{ $company->direccion ?? 'Dirección de la empresa' }}</div>
                @if($company->telefono ?? null)
                    <div class="company-details"><strong>Teléfono:</strong> {{ $company->telefono }}</div>
                @endif
                @if($company->email ?? null)
                    <div class="company-details"><strong>Email:</strong> {{ $company->email }}</div>
                @endif
                @if($company->web ?? null)
                    <div class="company-details"><strong>Web:</strong> {{ $company->web }}</div>
                @endif
            </div>
        </div>
        <div class="header-right">
            <div class="document-info">
                <div class="ruc-info">R.U.C. {{ $company->ruc ?? '20000000000' }}</div>
                <div class="document-type">FACTURA ELECTRÓNICA</div>
                <div class="document-number">{{ $document->numero_completo ?? 'F001-00000001' }}</div>
            </div>
        </div>
    </div>

    <!-- Document Data Section -->
    <div class="data-section">
        <table class="data-table">
            <tr>
                <td class="data-label">FECHA DE EMISIÓN:</td>
                <td class="data-value">{{ $fecha_emision ?? '' }}</td>
                <td class="data-label">MONEDA:</td>
                <td class="data-value">{{ $totales['moneda_nombre'] ?? 'SOLES' }}</td>
            </tr>
            @if($fecha_vencimiento ?? null)
            <tr>
                <td class="data-label">FECHA DE VENCIMIENTO:</td>
                <td class="data-value">{{ $fecha_vencimiento }}</td>
                <td class="data-label">TIPO DE CAMBIO:</td>
                <td class="data-value">{{ $document->tipo_cambio ?? '' }}</td>
            </tr>
            @endif
            @if($document->orden_compra ?? null)
            <tr>
                <td class="data-label">ORDEN DE COMPRA:</td>
                <td class="data-value">{{ $document->orden_compra }}</td>
                <td class="data-label">GUÍA DE REMISIÓN:</td>
                <td class="data-value">{{ $document->guia_remision ?? '' }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Client Data Section -->
    <div class="data-section">
        <div class="section-title">DATOS DEL ADQUIRIENTE O USUARIO</div>
        <table class="data-table">
            <tr>
                <td class="data-label">DOCUMENTO DE IDENTIDAD:</td>
                <td class="data-value">{{ ($client['tipo_documento'] ?? '6') == '6' ? 'RUC' : 'DNI' }}: {{ $client['numero_documento'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="data-label">APELLIDOS Y NOMBRES / RAZÓN SOCIAL:</td>
                <td class="data-value" style="width: 75%;">{{ $client['razon_social'] ?? 'CLIENTE' }}</td>
            </tr>
            @if(!empty($client['direccion'] ?? ''))
            <tr>
                <td class="data-label">DIRECCIÓN:</td>
                <td class="data-value">{{ $client['direccion'] }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Items Section -->
    <div class="items-section">
        <table class="items-table">
            <thead>
                <tr>
                    <th class="col-item">ÍTEM</th>
                    <th class="col-qty">CANT.</th>
                    <th class="col-unit">UND.</th>
                    <th class="col-code">CÓDIGO</th>
                    <th class="col-desc">DESCRIPCIÓN</th>
                    <th class="col-price">V.UNIT.</th>
                    <th class="col-value">V.VENTA</th>
                    <th class="col-total">IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                @if(is_array($detalles ?? []) && count($detalles) > 0)
                    @foreach($detalles as $index => $detalle)
                    <tr>
                        <td class="text-center">{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="text-center">{{ number_format($detalle['cantidad'] ?? 0, 2) }}</td>
                        <td class="text-center">{{ $detalle['unidad'] ?? 'NIU' }}</td>
                        <td class="text-center">{{ $detalle['codigo'] ?? '' }}</td>
                        <td class="text-left description-col">{{ $detalle['descripcion'] ?? 'PRODUCTO O SERVICIO' }}</td>
                        <td class="text-right">{{ number_format($detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
                        <td class="text-right">{{ number_format(($detalle['cantidad'] ?? 0) * ($detalle['mto_valor_unitario'] ?? 0), 2) }}</td>
                        <td class="text-right">{{ number_format((($detalle['cantidad'] ?? 0) * ($detalle['mto_valor_unitario'] ?? 0)) * 1.18, 2) }}</td>
                    </tr>
                    @endforeach
                    
                    <!-- Fill remaining rows for compact layout -->
                    @for($i = count($detalles); $i < 8; $i++)
                    <tr>
                        <td class="text-center">{{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endfor
                @else
                    @for($i = 0; $i < 8; $i++)
                    <tr>
                        <td class="text-center">{{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>

    <!-- Totals Section -->
    <div class="totals-section">
        <div class="totals-left">
            <!-- Amount in Words -->
            <div class="amount-words">
                <strong>SON:</strong><br>
                {{ (new \App\Services\PdfService())->numeroALetras($totales['total'] ?? 0) }} {{ $totales['moneda_nombre'] ?? 'SOLES' }}
            </div>

            <!-- Observations -->
            @if($document->observaciones ?? null)
            <div class="observations">
                <strong>OBSERVACIONES:</strong><br>
                {{ $document->observaciones }}
            </div>
            @endif
        </div>

        <div class="totals-right">
            <table class="totals-table">
                <tr>
                    <td class="totals-label">OP. GRAVADAS:</td>
                    <td class="totals-value">S/. {{ $totales['subtotal_formatted'] ?? '0.00' }}</td>
                </tr>
                <tr>
                    <td class="totals-label">OP. INAFECTAS:</td>
                    <td class="totals-value">S/. 0.00</td>
                </tr>
                <tr>
                    <td class="totals-label">OP. EXONERADAS:</td>
                    <td class="totals-value">S/. 0.00</td>
                </tr>
                <tr>
                    <td class="totals-label">OP. GRATUITAS:</td>
                    <td class="totals-value">S/. 0.00</td>
                </tr>
                <tr>
                    <td class="totals-label">DESCUENTOS:</td>
                    <td class="totals-value">S/. 0.00</td>
                </tr>
                <tr>
                    <td class="totals-label">I.G.V. (18%):</td>
                    <td class="totals-value">S/. {{ $totales['igv_formatted'] ?? '0.00' }}</td>
                </tr>
                <tr>
                    <td class="totals-label">I.S.C.:</td>
                    <td class="totals-value">S/. 0.00</td>
                </tr>
                <tr>
                    <td class="totals-label">OTROS TRIBUTOS:</td>
                    <td class="totals-value">S/. 0.00</td>
                </tr>
                <tr class="total-final">
                    <td class="totals-label">IMPORTE TOTAL:</td>
                    <td class="totals-value">S/. {{ $totales['total_formatted'] ?? '0.00' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer-section">
        <div class="qr-info-container">
            <div class="qr-section">
                <div class="qr-code">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Factura" alt="Código QR Factura">
                </div>
                <div style="font-size: 7px; text-align: center;">
                    Representación impresa<br>
                    de la Factura Electrónica
                </div>
            </div>
            <div class="footer-info">
                <div class="footer-text">
                    <b>USUARIO:</b> JOSUE PADILLA - 16/05/2023 04:21 PM<br>
                    <b>CONDICIÓN DE PAGO:</b> CONTADO (EFECTIVO)<br>
                    <b>CUENTAS BANCARIAS:</b> BCP SOLES: 45121455317979983352 CCI: 451316544616321<br>
                    YAPE/PLIN: 935022549<br><br>
                    
                    <strong>INFORMACIÓN COMPLEMENTARIA:</strong><br>
                    • Esta factura ha sido generada en el Sistema de Emisión Electrónica de SUNAT.<br>
                    • Para verificar la autenticidad del documento, ingrese a www.sunat.gob.pe<br>
                    @if($document->forma_pago ?? null)
                    • Forma de Pago: {{ $document->forma_pago }}<br>
                    @endif
                    @if($document->condicion_pago ?? null)
                    • Condición de Pago: {{ $document->condicion_pago }}<br>
                    @endif
                </div>

                @if($document->codigo_hash ?? null)
                <div class="hash-info">
                    <strong>CÓDIGO HASH:</strong> {{ $document->codigo_hash }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SUNAT Disclaimer -->
    <div class="sunat-disclaimer">
        <strong>Autorizado mediante Resolución de Intendencia N° 034-005-0000185/SUNAT</strong><br>
        Para ser reconocido como Comprobante de Pago a los efectos del Reglamento de<br>
        Comprobantes de Pago, debe ser impreso conforme a las disposiciones del mismo.
    </div>

    </div>
</body>
</html>