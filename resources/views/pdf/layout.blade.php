<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .company-info {
            flex: 2;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .company-address {
            font-size: 10px;
            color: #666;
            margin-bottom: 2px;
        }
        
        .document-box {
            flex: 1;
            border: 2px solid #333;
            padding: 10px;
            text-align: center;
            margin-left: 20px;
        }
        
        .document-type {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .document-number {
            font-size: 12px;
            font-weight: bold;
        }
        
        .client-section {
            margin: 20px 0;
            border: 1px solid #ccc;
            padding: 15px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .client-row {
            display: flex;
            margin-bottom: 5px;
        }
        
        .client-label {
            font-weight: bold;
            width: 120px;
        }
        
        .client-value {
            flex: 1;
        }
        
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .details-table th {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }
        
        .details-table td {
            border: 1px solid #ccc;
            padding: 6px;
            font-size: 11px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-left {
            text-align: left;
        }
        
        .totals-section {
            float: right;
            width: 300px;
            margin-top: 10px;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .totals-table td {
            border: 1px solid #ccc;
            padding: 6px;
            font-size: 11px;
        }
        
        .totals-table .label {
            font-weight: bold;
            background-color: #f5f5f5;
            width: 60%;
        }
        
        .totals-table .value {
            text-align: right;
            font-weight: bold;
        }
        
        .footer {
            clear: both;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
        }
        
        .amount-words {
            margin: 20px 0;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .observations {
            margin: 15px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        
        .small {
            font-size: 10px;
        }
        
        .bold {
            font-weight: bold;
        }
        
        .mt-10 {
            margin-top: 10px;
        }
        
        .mb-10 {
            margin-bottom: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }

        @media print {
            .container {
                padding: 0;
                max-width: none;
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