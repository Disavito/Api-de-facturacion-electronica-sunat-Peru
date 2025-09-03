<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tipo_documento_nombre ?? 'COMPROBANTE' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #000;
            width: 78mm; /* Ancho para 80mm */
            margin: 0 auto;
        }

        .ticket {
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .logo {
            display: block;
            margin: 0 auto 10px;
            max-width: 120px;
            max-height: 80px;
        }

        .company-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        p {
            margin-bottom: 2px;
        }

        .document-info {
            margin: 10px 0;
            text-align: center;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
        }

        .document-title {
            font-size: 12px;
            font-weight: bold;
        }

        .client-info {
            margin-bottom: 10px;
        }

        .client-info table {
            width: 100%;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .items-table thead {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .items-table th,
        .items-table td {
            padding: 4px;
            vertical-align: top;
        }

        .items-table th {
            font-weight: bold;
        }

        .items-table tbody td {
            border-bottom: 1px dotted #000;
        }

        .totals {
            margin-bottom: 10px;
        }

        .totals-table {
            width: 100%;
        }

        .totals-table td:last-child {
            width: 40%;
        }

        .additional-info .section {
            margin-bottom: 10px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-size: 9px;
        }

        .hash {
            word-break: break-all;
            font-size: 8px;
        }

    </style>
</head>
<body>
    @yield('content')
</body>
</html>
