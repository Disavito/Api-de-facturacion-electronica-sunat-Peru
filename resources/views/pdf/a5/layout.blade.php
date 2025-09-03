<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COMPROBANTE ELECTRÓNICO')</title>
    <style>
        /* ================= BASE ================= */
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 148mm;
            height: 210mm;
            margin: auto;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #000;
            border-radius: 8px;
        }

        /* ================= HEADER ================= */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .empresa {
            width: 65%;
        }

        .empresa h2 {
            margin: 0 0 8px 0;
            font-size: 11px;
        }

        .empresa p {
            line-height: 1.6;
            margin: 0;
            font-size: 8px;
        }

        .factura {
            width: 30%;
            border: 1px solid #000;
            border-radius: 6px;
            text-align: center;
            padding: 4px;
            font-size: 9px;
        }

        /* ================= DATOS ================= */
        .datos {
            margin-top: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 8px;
        }

        .datos div {
            width: 48%;
        }

        .datos p {
            line-height: 1.6;
            margin: 0;
            padding: 6px 0;
        }

        /* ================= TABLA PRINCIPAL ================= */
        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            font-size: 8px;
            border: 1px solid #000;
            border-radius: 6px;
        }

        /* Tabla de items con altura reducida para A5 */
        table:not(.en-letras):not(.totales) {
            height: 280px;
        }

        /* Última fila de items extendida */
        table:not(.en-letras):not(.totales) tbody tr:last-child td {
            height: 100%;
            vertical-align: top;
        }

        thead {
            background-color: #f0f0f0;
        }

        th,
        td {
            border-right: 1px solid #000;
            padding: 3px;
            text-align: left;
        }

        /* Primera columna sin borde izquierdo */
        th:first-child,
        td:first-child {
            border-left: none;
        }

        /* Última fila sin borde inferior */
        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Última columna sin borde derecho */
        th:last-child,
        td:last-child {
            border-right: none;
        }

        /* Header con borde superior para esquinas redondeadas */
        thead th {
            border-bottom: 1px solid #000;
        }

        /* Esquinas redondeadas para el header */
        thead th:first-child {
            border-top-left-radius: 4px;
        }

        thead th:last-child {
            border-top-right-radius: 4px;
        }

        /* Esquinas redondeadas para la última fila */
        tbody tr:last-child td:first-child {
            border-bottom-left-radius: 4px;
        }

        tbody tr:last-child td:last-child {
            border-bottom-right-radius: 4px;
        }

        /* Columnas numéricas alineadas a la derecha */
        th:nth-child(5),
        th:nth-child(6),
        td:nth-child(5),
        td:nth-child(6) {
            text-align: right;
        }

        /* ================= SON EN LETRAS ================= */
        .en-letras {
            margin-top: 4px;
        }

        .en-letras td {
            text-align: center;
            font-weight: bold;
            padding: 4px;
            font-size: 8px;
        }

        /* ================= TOTALES ================= */
        .totales {
            margin-top: 8px;
        }

        .totales td {
            padding: 4px 6px;
            font-size: 8px;
            vertical-align: top;
        }

        .totales .label {
            text-align: right;
            font-weight: bold;
            width: 100px;
        }

        .totales .resaltado {
            background: #f0f0f0;
            font-weight: bold;
        }

        /* Info + QR en misma celda */
        .qr-info-container {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 3px;
        }

        .info-footer {
            font-size: 7px;
            text-align: left;
            flex: 1;
        }

        .qr {
            flex-shrink: 0;
        }

        .qr img {
            width: 80px;
            height: 80px;
            display: block;
        }

        /* ================= FOOTER EXTRA ================= */
        .footer-extra {
            margin-top: 12px;
            padding: 8px;
            border: 1px solid #000;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
        }

        .sunat-info,
        .empresa-info {
            flex: 1;
        }

        .footer-extra h4 {
            margin: 0 0 6px 0;
            font-size: 9px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        .footer-extra p {
            margin: 3px 0;
            font-size: 7px;
            line-height: 1.3;
        }

        .footer-bottom {
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }

        .footer-bottom p {
            margin: 2px 0;
            font-size: 7px;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .bold { font-weight: bold; }
        .upper { text-transform: uppercase; }

        /* ================= PRINT ================= */
        @media print {
            body {
                margin: 0;
            }

            .container {
                border: none;
                padding: 0;
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