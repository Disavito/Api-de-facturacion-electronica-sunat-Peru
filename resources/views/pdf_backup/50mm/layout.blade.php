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
            font-size: 8px; /* Smaller base font size */
            line-height: 1.3;
            color: #000;
            width: 48mm; /* Ancho para 50mm */
            margin: 0 auto;
        }

        .ticket {
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .logo {
            display: block;
            margin: 0 auto 5px;
            max-width: 80px;
            max-height: 60px;
        }

        .company-name {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        p {
            margin-bottom: 1px;
        }

        .document-info {
            margin: 5px 0;
            text-align: center;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 3px 0;
        }

        .document-title {
            font-size: 9px;
            font-weight: bold;
        }

        .client-info {
            margin-bottom: 5px;
        }

        .client-info table {
            width: 100%;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .items-table thead {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .items-table th,
        .items-table td {
            padding: 2px;
            vertical-align: top;
            font-size: 7px;
        }

        .items-table th {
            font-weight: bold;
        }

        .items-table tbody td {
            border-bottom: 1px dotted #000;
        }

        /* Adjust columns for smaller width */
        .items-table th:nth-child(1), .items-table td:nth-child(1) { width: 15%; } /* Codigo */
        .items-table th:nth-child(2), .items-table td:nth-child(2) { width: 40%; } /* Descripcion */
        .items-table th:nth-child(3), .items-table td:nth-child(3) { width: 15%; } /* Cant */
        .items-table th:nth-child(4), .items-table td:nth-child(4) { width: 15%; } /* P. Unit */
        .items-table th:nth-child(5), .items-table td:nth-child(5) { width: 15%; } /* Importe */


        .totals {
            margin-bottom: 5px;
        }

        .totals-table {
            width: 100%;
        }

        .totals-table td:last-child {
            width: 45%;
        }

        .additional-info .section {
            margin-bottom: 5px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .footer {
            text-align: center;
            margin-top: 5px;
            border-top: 1px solid #000;
            padding-top: 3px;
            font-size: 7px;
        }

        .hash {
            word-break: break-all;
            font-size: 6px;
        }

    </style>
</head>
<body>
    @yield('content')
</body>
</html>
