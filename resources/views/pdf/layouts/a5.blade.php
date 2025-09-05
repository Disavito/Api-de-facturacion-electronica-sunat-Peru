@extends('pdf.layouts.base')

@section('format-styles')
<style>
    /* ================= A5 FORMAT (148x210mm) ================= */
    body {
        font-size: 10px;
        line-height: 1.3;
    }

    .container {
        width: 13cm;
        margin: auto;
        padding: 12px;
        box-sizing: border-box;
        border: 1px solid #000;
        border-radius: 8px;
    }

    /* ================= HEADER ================= */
    .header {
        display: table;
        width: 100%;
        border-bottom: 1px solid #000;
        padding-bottom: 12px;
        margin-bottom: 12px;
        table-layout: fixed;
    }

    .header > div {
        display: table-cell;
        vertical-align: top;
        padding: 4px;
    }

    .logo-section {
        width: 25%;
        text-align: left;
    }

    .logo-img {
        width: 50px;
        height: 50px;
        object-fit: contain;
        vertical-align: top;
        margin-right: 8px;
        display: block;
    }

    .company-section {
        width: 50%;
        text-align: left;
        padding-left: 8px;
    }

    .company-name {
        font-size: 13px;
        font-weight: bold;
        color: #333;
        margin-bottom: 4px;
    }

    .company-details {
        font-size: 8px;
        color: #666;
        line-height: 1.3;
    }

    .document-section {
        width: 25%;
        text-align: center;
        border: 2px solid #000;
        border-radius: 6px;
        padding: 8px;
    }

    .document-title {
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 4px;
        color: #000;
    }

    .document-number {
        font-size: 13px;
        font-weight: bold;
        color: #000;
        margin-bottom: 4px;
    }

    .document-date {
        font-size: 8px;
        color: #666;
    }

    /* ================= CLIENT INFO ================= */
    .client-info {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 8px;
        margin-bottom: 12px;
        background-color: #f9f9f9;
    }

    .client-info-title {
        font-size: 10px;
        font-weight: bold;
        margin-bottom: 6px;
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
        width: 100px;
        font-weight: bold;
        font-size: 8px;
        padding: 2px 4px 2px 0;
        color: #333;
    }

    .client-details .value {
        display: table-cell;
        font-size: 8px;
        padding: 2px 0;
        color: #000;
    }

    /* ================= ITEMS TABLE ================= */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 12px;
        font-size: 8px;
    }

    .items-table th {
        background-color: #f0f0f0;
        font-weight: bold;
        padding: 6px 3px;
        border: 1px solid #000;
        text-align: center;
        font-size: 7px;
    }

    .items-table td {
        padding: 4px 3px;
        border: 1px solid #ccc;
        vertical-align: top;
        font-size: 7px;
    }

    /* Column widths A5 */
    .col-codigo { width: 10%; }
    .col-descripcion { width: 40%; }
    .col-cantidad { width: 10%; }
    .col-unidad { width: 8%; }
    .col-precio { width: 12%; }
    .col-descuento { width: 8%; }
    .col-subtotal { width: 12%; }
    .col-igv { width: 10%; }
    .col-total { width: 15%; }

    /* ================= TOTALS SECTION ================= */
    .totals-section {
        display: table;
        width: 100%;
        margin-bottom: 12px;
    }

    .totals-left {
        display: table-cell;
        width: 45%;
        vertical-align: top;
        padding-right: 12px;
    }

    .totals-right {
        display: table-cell;
        width: 55%;
        vertical-align: top;
    }

    .totals-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8px;
    }

    .totals-table td {
        padding: 2px 4px;
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
        font-size: 10px;
        font-weight: bold;
        border-top: 2px solid #000;
        border-bottom: 2px solid #000;
        background-color: #f0f0f0;
        padding: 4px;
    }

    /* ================= ADDITIONAL INFO ================= */
    .additional-info {
        margin-bottom: 12px;
    }

    .additional-info .section-title {
        font-size: 9px;
        font-weight: bold;
        margin-bottom: 4px;
        color: #333;
    }

    .additional-info .content {
        font-size: 7px;
        line-height: 1.3;
        color: #000;
    }

    /* ================= QR CODE ================= */
    .qr-section {
        text-align: center;
        margin: 12px 0;
    }

    .qr-code {
        margin: 8px auto;
    }

    .qr-info {
        font-size: 6px;
        color: #666;
        margin-top: 4px;
    }

    /* ================= FOOTER ================= */
    .footer {
        border-top: 1px solid #ccc;
        padding-top: 8px;
        text-align: center;
        font-size: 6px;
        color: #666;
    }

    .hash-section {
        margin-top: 8px;
        font-size: 5px;
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