<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tipo_documento_nombre ?? 'COMPROBANTE ELECTRÓNICO' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: {{ $format === '50mm' ? '7px' : '9px' }};
            line-height: 1.3;
            color: #000;
            width: 100%;
            background: white;
        }

        .container {
            width: 100%;
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
        }

        /* ================== HEADER ================== */
        .header {
            text-align: center;
            margin-bottom: {{ $format === '50mm' ? '3mm' : '4mm' }};
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
            border: 1px solid #ddd;
        }

        .company-logo {
            width: {{ $format === '50mm' ? '15mm' : '20mm' }};
            height: {{ $format === '50mm' ? '15mm' : '20mm' }};
            margin: 0 auto {{ $format === '50mm' ? '1mm' : '2mm' }};
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #4a90e2;
        }

        .company-logo img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 50%;
        }

        .company-name {
            font-weight: bold;
            font-size: {{ $format === '50mm' ? '8px' : '11px' }};
            margin-bottom: {{ $format === '50mm' ? '1mm' : '2mm' }};
            color: #2c3e50;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .company-info {
            font-size: {{ $format === '50mm' ? '6px' : '8px' }};
            line-height: 1.2;
            color: #34495e;
        }

        /* ================== DOCUMENT INFO ================== */
        .document-info {
            text-align: center;
            margin: {{ $format === '50mm' ? '3mm' : '4mm' }} 0;
            background: #34495e;
            color: white;
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
            font-weight: bold;
            font-size: {{ $format === '50mm' ? '7px' : '9px' }};
        }

        .document-type {
            font-size: {{ $format === '50mm' ? '8px' : '10px' }};
            margin-bottom: 1mm;
            letter-spacing: 0.5px;
        }

        .document-number {
            font-size: {{ $format === '50mm' ? '9px' : '12px' }};
            font-weight: bold;
            margin: 1mm 0;
        }

        .document-date {
            font-size: {{ $format === '50mm' ? '7px' : '8px' }};
            opacity: 0.9;
        }

        /* ================== CLIENT INFO ================== */
        .client-info {
            margin: {{ $format === '50mm' ? '3mm' : '4mm' }} 0;
            background: #ecf0f1;
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
            border-left: 3px solid #3498db;
        }

        .client-info .label {
            font-weight: bold;
            color: #2980b9;
            margin-bottom: 1mm;
        }

        .client-info .value {
            color: #2c3e50;
            margin-bottom: 0.5mm;
        }

        /* ================== DETAILS TABLE ================== */
        .details-section {
            margin: {{ $format === '50mm' ? '3mm' : '4mm' }} 0;
        }

        .section-title {
            background: #3498db;
            color: white;
            padding: {{ $format === '50mm' ? '1mm' : '2mm' }};
            font-weight: bold;
            font-size: {{ $format === '50mm' ? '7px' : '8px' }};
            text-align: center;
            margin-bottom: 1mm;
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }} {{ $format === '50mm' ? '1mm' : '2mm' }} 0 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 0 0 {{ $format === '50mm' ? '1mm' : '2mm' }} {{ $format === '50mm' ? '1mm' : '2mm' }};
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .details-table th {
            background: #f8f9fa;
            font-weight: bold;
            padding: {{ $format === '50mm' ? '1mm' : '2mm' }};
            font-size: {{ $format === '50mm' ? '6px' : '7px' }};
            border-bottom: 1px solid #dee2e6;
            color: #495057;
        }

        .details-table td {
            padding: {{ $format === '50mm' ? '1mm' : '2mm' }};
            font-size: {{ $format === '50mm' ? '6px' : '7px' }};
            border-bottom: 1px dotted #e9ecef;
            vertical-align: top;
        }

        .details-table tbody tr:hover {
            background: #f8f9fa;
        }

        .details-table tbody tr:last-child td {
            border-bottom: none;
        }

        .item-code {
            font-style: italic;
            color: #6c757d;
        }

        /* ================== TOTALS ================== */
        .totals {
            margin-top: {{ $format === '50mm' ? '3mm' : '4mm' }};
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: {{ $format === '50mm' ? '0.5mm' : '1mm' }} 0;
            font-size: {{ $format === '50mm' ? '7px' : '8px' }};
            padding: {{ $format === '50mm' ? '0.5mm' : '1mm' }} 0;
        }

        .total-row.subtotal {
            opacity: 0.9;
            font-size: {{ $format === '50mm' ? '6px' : '7px' }};
        }

        .total-final {
            font-weight: bold;
            font-size: {{ $format === '50mm' ? '8px' : '10px' }};
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: {{ $format === '50mm' ? '1mm' : '2mm' }};
            margin-top: {{ $format === '50mm' ? '1mm' : '2mm' }};
            background: rgba(255,255,255,0.1);
            border-radius: {{ $format === '50mm' ? '0.5mm' : '1mm' }};
            padding: {{ $format === '50mm' ? '1mm' : '2mm' }};
        }

        .amount-in-words {
            margin-top: {{ $format === '50mm' ? '2mm' : '3mm' }};
            background: #e8f4fd;
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
            border-left: 3px solid #2196f3;
            color: #1565c0;
            font-size: {{ $format === '50mm' ? '6px' : '7px' }};
            font-weight: bold;
            text-align: center;
        }

        /* ================== QR & FOOTER ================== */
        .qr-section {
            text-align: center;
            margin: {{ $format === '50mm' ? '3mm' : '4mm' }} 0;
            background: #f8f9fa;
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
            border: 1px dashed #6c757d;
        }

        .qr-code {
            width: {{ $format === '50mm' ? '20mm' : '25mm' }};
            height: {{ $format === '50mm' ? '20mm' : '25mm' }};
            margin: 0 auto {{ $format === '50mm' ? '1mm' : '2mm' }};
            background: #fff;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
        }

        .qr-code img {
            max-width: 90%;
            max-height: 90%;
        }

        .qr-text {
            font-size: {{ $format === '50mm' ? '5px' : '6px' }};
            color: #6c757d;
            margin-top: {{ $format === '50mm' ? '1mm' : '2mm' }};
        }

        .footer {
            text-align: center;
            margin-top: {{ $format === '50mm' ? '4mm' : '5mm' }};
            font-size: {{ $format === '50mm' ? '5px' : '6px' }};
            color: #6c757d;
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
            background: #f1f3f4;
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
            line-height: 1.4;
        }

        .footer-line {
            margin: {{ $format === '50mm' ? '0.5mm' : '1mm' }} 0;
        }

        /* ================== UTILITIES ================== */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .break-word {
            word-break: break-word;
            word-wrap: break-word;
        }

        .bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic;
        }

        .separator {
            border-top: 1px dashed #bdc3c7;
            margin: {{ $format === '50mm' ? '2mm' : '3mm' }} 0;
        }

        .highlight-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: {{ $format === '50mm' ? '1mm' : '2mm' }};
            border-radius: {{ $format === '50mm' ? '1mm' : '2mm' }};
            margin: {{ $format === '50mm' ? '1mm' : '2mm' }} 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                height: auto;
            }
            
            .header, .totals {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>