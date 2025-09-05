@extends('pdf.layouts.base')

@section('format-styles')
<style>
    /* ================= A4 FORMAT (210x297mm) ================= */
    body {
        font-size: 12px;
        line-height: 1.4;
    }

    .container {
        width: 18cm;
        margin: auto;
        padding: 15px;
        box-sizing: border-box;
        border: 1px solid #000;
        border-radius: 10px;
    }

    /* ================= HEADER ================= */
    .header {
        display: table;
        width: 100%;
        border-bottom: 1px solid #000;
        padding-bottom: 15px;
        margin-bottom: 15px;
        table-layout: fixed;
    }

    .header > div {
        display: table-cell;
        vertical-align: top;
        padding: 5px;
    }

    .logo-section {
        width: 25%;
        text-align: left;
    }

    .logo-img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        vertical-align: top;
        margin-right: 10px;
        display: block;
    }

    .company-section {
        width: 50%;
        text-align: left;
        padding-left: 10px;
    }

    .company-name {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .company-details {
        font-size: 10px;
        color: #666;
        line-height: 1.4;
    }

    .document-section {
        width: 25%;
        text-align: center;
        border: 2px solid #000;
        border-radius: 8px;
        padding: 10px;
    }

    .document-title {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #000;
    }

    .document-number {
        font-size: 16px;
        font-weight: bold;
        color: #000;
        margin-bottom: 5px;
    }

    .document-date {
        font-size: 10px;
        color: #666;
    }

    /* ================= CLIENT INFO ================= */
    .client-info {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
    }

    .client-info-title {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #333;
    }

    .client-details {
        display: table;
        width: 100%;
    }

    .client-details .row {
        display: table-row;
    }

    .client-details .label {
        display: table-cell;
        width: 120px;
        font-weight: bold;
        font-size: 10px;
        padding: 2px 5px 2px 0;
        color: #333;
    }

    .client-details .value {
        display: table-cell;
        font-size: 10px;
        padding: 2px 0;
        color: #000;
    }

    /* ================= ITEMS TABLE ================= */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        font-size: 10px;
    }

    .items-table th {
        background-color: #f0f0f0;
        font-weight: bold;
        padding: 8px 4px;
        border: 1px solid #000;
        text-align: center;
        font-size: 9px;
    }

    .items-table td {
        padding: 5px 4px;
        border: 1px solid #ccc;
        vertical-align: top;
        font-size: 9px;
    }

    /* Column widths A4 */
    .col-codigo { width: 8%; }
    .col-descripcion { width: 42%; }
    .col-cantidad { width: 8%; }
    .col-unidad { width: 8%; }
    .col-precio { width: 10%; }
    .col-descuento { width: 8%; }
    .col-subtotal { width: 10%; }
    .col-igv { width: 8%; }
    .col-total { width: 12%; }

    /* ================= TOTALS SECTION ================= */
    .totals-section {
        display: table;
        width: 100%;
        margin-bottom: 15px;
    }

    .totals-left {
        display: table-cell;
        width: 50%;
        vertical-align: top;
        padding-right: 15px;
    }

    .totals-right {
        display: table-cell;
        width: 50%;
        vertical-align: top;
    }

    .totals-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
    }

    .totals-table td {
        padding: 3px 5px;
        border-bottom: 1px dotted #ccc;
    }

    .totals-table .label {
        text-align: left;
        font-weight: normal;
        width: 70%;
    }

    .totals-table .value {
        text-align: right;
        font-weight: bold;
        width: 30%;
    }

    .totals-table .total-final .label,
    .totals-table .total-final .value {
        font-size: 12px;
        font-weight: bold;
        border-top: 2px solid #000;
        border-bottom: 2px solid #000;
        background-color: #f0f0f0;
        padding: 5px;
    }

    /* ================= ADDITIONAL INFO ================= */
    .additional-info {
        margin-bottom: 15px;
    }

    .additional-info .section-title {
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .additional-info .content {
        font-size: 9px;
        line-height: 1.4;
        color: #000;
    }

    /* ================= QR CODE ================= */
    .qr-section {
        text-align: center;
        margin: 15px 0;
    }

    .qr-code {
        margin: 10px auto;
    }

    .qr-info {
        font-size: 8px;
        color: #666;
        margin-top: 5px;
    }

    /* ================= FOOTER ================= */
    .footer {
        border-top: 1px solid #ccc;
        padding-top: 10px;
        text-align: center;
        font-size: 8px;
        color: #666;
    }

    .hash-section {
        margin-top: 10px;
        font-size: 7px;
        color: #999;
        word-break: break-all;
    }
</style>
@endsection

@section('body-content')
<div class="container">
    @yield('content')
</div>
@endsection