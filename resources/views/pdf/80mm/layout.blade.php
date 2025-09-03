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
            font-family: 'Courier New', monospace;
            font-size: {{ $format === '50mm' ? '6px' : '8px' }};
            line-height: 1.2;
            color: #000;
            width: 100%;
            background: white;
        }

        .container {
            width: 100%;
            padding: {{ $format === '50mm' ? '2mm' : '3mm' }};
        }

        .header {
            text-align: center;
            margin-bottom: {{ $format === '50mm' ? '2mm' : '3mm' }};
            border-bottom: 1px dashed #000;
            padding-bottom: {{ $format === '50mm' ? '1mm' : '2mm' }};
        }

        .company-name {
            font-weight: bold;
            font-size: {{ $format === '50mm' ? '7px' : '10px' }};
            margin-bottom: 1mm;
        }

        .company-info {
            font-size: {{ $format === '50mm' ? '5px' : '7px' }};
            line-height: 1.1;
        }

        .document-info {
            text-align: center;
            margin: {{ $format === '50mm' ? '2mm' : '3mm' }} 0;
            font-weight: bold;
            font-size: {{ $format === '50mm' ? '6px' : '8px' }};
        }

        .client-info {
            margin: {{ $format === '50mm' ? '2mm' : '3mm' }} 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: {{ $format === '50mm' ? '1mm' : '2mm' }} 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: {{ $format === '50mm' ? '2mm' : '3mm' }} 0;
        }

        .details-table th,
        .details-table td {
            text-align: left;
            padding: {{ $format === '50mm' ? '0.5mm' : '1mm' }};
            font-size: {{ $format === '50mm' ? '5px' : '7px' }};
            border-bottom: 1px dotted #ccc;
        }

        .details-table th {
            font-weight: bold;
            border-bottom: 1px solid #000;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            margin-top: {{ $format === '50mm' ? '2mm' : '3mm' }};
            border-top: 1px dashed #000;
            padding-top: {{ $format === '50mm' ? '1mm' : '2mm' }};
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: {{ $format === '50mm' ? '0.5mm' : '1mm' }} 0;
            font-size: {{ $format === '50mm' ? '6px' : '8px' }};
        }

        .total-final {
            font-weight: bold;
            font-size: {{ $format === '50mm' ? '7px' : '9px' }};
            border-top: 1px solid #000;
            padding-top: 1mm;
        }

        .footer {
            text-align: center;
            margin-top: {{ $format === '50mm' ? '3mm' : '4mm' }};
            font-size: {{ $format === '50mm' ? '5px' : '6px' }};
            border-top: 1px dashed #000;
            padding-top: {{ $format === '50mm' ? '1mm' : '2mm' }};
        }

        .qr-section {
            text-align: center;
            margin: {{ $format === '50mm' ? '2mm' : '3mm' }} 0;
        }

        .break-word {
            word-break: break-all;
            word-wrap: break-word;
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
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>