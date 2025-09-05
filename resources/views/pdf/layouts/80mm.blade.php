@extends('pdf.layouts.base')

@section('format-styles')
<style>
    /* ================= 80MM TICKET FORMAT ================= */
    body {
        font-size: 8px;
        line-height: 1.2;
        color: #333;
        padding: 4px;
        width: 74mm;
    }

    .container {
        width: 100%;
        padding: 0;
    }

    /* ================= HEADER ================= */
    .header {
        text-align: center;
        margin-bottom: 8px;
        border-bottom: 1px dashed #000;
        padding-bottom: 6px;
    }

    .logo-section-ticket {
        text-align: center;
        margin-bottom: 4px;
    }

    .logo-img-ticket {
        width: 50px;
        height: 50px;
        object-fit: contain;
        display: block;
        margin: 0 auto 4px;
    }

    .company-name {
        font-size: 10px;
        font-weight: bold;
        margin-bottom: 3px;
        text-transform: uppercase;
    }

    .company-details {
        font-size: 7px;
        line-height: 1.1;
        margin-bottom: 4px;
    }

    .document-info {
        font-size: 8px;
        font-weight: bold;
        margin: 4px 0;
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        padding: 4px 0;
    }

    .document-title {
        font-size: 9px;
        font-weight: bold;
    }

    /* ================= CLIENT INFO ================= */
    .client-section {
        margin: 6px 0;
        font-size: 7px;
        border-bottom: 1px dashed #000;
        padding-bottom: 6px;
    }

    .client-row {
        margin-bottom: 2px;
        word-wrap: break-word;
    }

    .client-label {
        font-weight: bold;
    }

    /* ================= DOCUMENT DETAILS ================= */
    .document-details {
        margin: 6px 0;
        font-size: 7px;
        border-bottom: 1px dashed #000;
        padding-bottom: 6px;
    }

    .detail-row {
        margin-bottom: 2px;
    }

    /* ================= TABLE ================= */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin: 6px 0;
        font-size: 7px;
    }

    .items-table th {
        background: #f0f0f0;
        font-weight: bold;
        padding: 3px 2px;
        border: 1px solid #000;
        text-align: center;
    }

    .items-table td {
        padding: 3px 2px;
        border: 1px solid #ccc;
        text-align: center;
        vertical-align: top;
    }

    /* Column widths 80mm */
    .col-codigo { width: 12%; }
    .col-descripcion { width: 38%; }
    .col-cantidad { width: 12%; }
    .col-unidad { width: 8%; }
    .col-precio { width: 15%; }
    .col-total { width: 15%; }

    /* ================= TOTALS ================= */
    .totals-section {
        margin: 6px 0;
        font-size: 7px;
        border-top: 1px dashed #000;
        padding-top: 6px;
    }

    .totals-table {
        width: 100%;
    }

    .totals-table td {
        padding: 2px 0;
    }

    .totals-table .label {
        text-align: left;
        width: 60%;
    }

    .totals-table .value {
        text-align: right;
        width: 40%;
        font-weight: bold;
    }

    .total-final {
        border-top: 1px solid #000;
        margin-top: 3px;
        padding-top: 3px;
    }

    .total-final .label,
    .total-final .value {
        font-weight: bold;
        font-size: 8px;
    }

    /* ================= ADDITIONAL INFO ================= */
    .additional-info {
        margin: 6px 0;
        font-size: 7px;
        border-top: 1px dashed #000;
        padding-top: 6px;
    }

    .additional-info .section {
        margin-bottom: 4px;
    }

    .additional-info .section-title {
        font-weight: bold;
        margin-bottom: 2px;
    }

    /* ================= QR CODE ================= */
    .qr-section {
        text-align: center;
        margin: 6px 0;
        border-top: 1px dashed #000;
        padding-top: 6px;
    }

    .qr-code {
        margin: 4px auto;
    }

    .qr-info {
        font-size: 6px;
        margin-top: 3px;
    }

    /* ================= FOOTER ================= */
    .footer {
        text-align: center;
        margin-top: 8px;
        border-top: 1px solid #000;
        padding-top: 4px;
        font-size: 6px;
    }

    .hash-section {
        word-break: break-all;
        font-size: 5px;
        margin-top: 3px;
    }

    /* ================= REFERENCE DOC ================= */
    .reference-doc {
        margin: 6px 0;
        font-size: 7px;
        border-bottom: 1px dashed #000;
        padding-bottom: 6px;
    }

    .reference-doc .section-title {
        font-weight: bold;
        margin-bottom: 3px;
    }
</style>
@endsection

@section('body-content')
<div class="container">
    @yield('content')
</div>
@endsection