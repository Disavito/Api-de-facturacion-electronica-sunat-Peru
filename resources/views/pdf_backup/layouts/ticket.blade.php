@extends('pdf.layouts.base')

@section('format-styles')
<style>
    /* ================= TICKET FORMAT SPECIFIC ================= */
    body {
        font-size: 7px;
        color: #333;
        padding: 3px;
        width: 46mm;
    }
    .container {
        width: 100%;
        padding: 0;
    }

    /* ================= HEADER ================= */
    .header {
        text-align: center;
        margin-bottom: 6px;
        border-bottom: 1px dashed #000;
        padding-bottom: 4px;
    }

    .company-name {
        font-size: 8px;
        font-weight: bold;
        margin-bottom: 2px;
    }

    .company-details {
        font-size: 6px;
        line-height: 1.1;
        margin-bottom: 3px;
    }

    .document-info {
        font-size: 7px;
        font-weight: bold;
        margin: 3px 0;
    }

    /* ================= CLIENT INFO ================= */
    .client-section {
        margin: 4px 0;
        font-size: 6px;
        border-bottom: 1px dashed #000;
        padding-bottom: 4px;
    }

    .client-row {
        margin-bottom: 1px;
        word-wrap: break-word;
    }

    .client-label {
        font-weight: bold;
    }

    /* ================= DOCUMENT DETAILS ================= */
    .document-details {
        margin: 4px 0;
        font-size: 6px;
        border-bottom: 1px dashed #000;
        padding-bottom: 4px;
    }

    .detail-row {
        margin-bottom: 1px;
    }

    /* ================= TABLE ================= */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin: 4px 0;
        font-size: 6px;
    }

    .items-table th {
        background: #f0f0f0;
        font-weight: bold;
        padding: 2px 1px;
        border: 1px solid #000;
        text-align: center;
    }

    .items-table td {
        padding: 2px 1px;
        border: 1px solid #ccc;
        text-align: center;
    }

    /* Column widths for ticket */
    .col-codigo { width: 15%; }
    .col-descripcion { width: 35%; }
    .col-cantidad { width: 12%; }
    .col-precio { width: 18%; }
    .col-total { width: 20%; }

    /* ================= TOTALS ================= */
    .totals-section {
        margin: 4px 0;
        font-size: 6px;
        border-top: 1px dashed #000;
        padding-top: 4px;
    }

    .totals-table {
        width: 100%;
    }

    .totals-table td {
        padding: 1px 0;
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
        margin-top: 2px;
        padding-top: 2px;
    }

    .total-final .label,
    .total-final .value {
        font-weight: bold;
        font-size: 7px;
    }

    /* ================= ADDITIONAL INFO ================= */
    .additional-info {
        margin: 4px 0;
        font-size: 6px;
        border-top: 1px dashed #000;
        padding-top: 4px;
    }

    .additional-info .section {
        margin-bottom: 3px;
    }

    .additional-info .section-title {
        font-weight: bold;
        margin-bottom: 1px;
    }

    /* ================= QR CODE ================= */
    .qr-section {
        text-align: center;
        margin: 4px 0;
        border-top: 1px dashed #000;
        padding-top: 4px;
    }

    .qr-code {
        margin: 3px auto;
    }

    .qr-info {
        font-size: 5px;
        margin-top: 2px;
    }

    /* ================= FOOTER ================= */
    .footer {
        text-align: center;
        margin-top: 5px;
        border-top: 1px solid #000;
        padding-top: 3px;
        font-size: 6px;
    }

    .hash-section {
        word-break: break-all;
        font-size: 5px;
        margin-top: 2px;
    }

    /* ================= REFERENCE DOC ================= */
    .reference-doc {
        margin: 4px 0;
        font-size: 6px;
        border-bottom: 1px dashed #000;
        padding-bottom: 4px;
    }

    .reference-doc .section-title {
        font-weight: bold;
        margin-bottom: 2px;
    }
</style>
@endsection

@section('body-content')
<div class="container">
    @yield('content')
</div>
@endsection