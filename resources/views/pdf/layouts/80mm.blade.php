@extends('pdf.layouts.base')

@section('format-styles')
<style>


    /* ================= BASE ================= */
    body {
        font-family: 'Helvetica';
        margin: 10pt;
        
    }

    .container {
        width: 100%;
        padding: 0;
    }

    /* ================= HEADER ================= */
    .header {
        text-align: center;
        margin-bottom: 3px;
    }

    .logo-section-ticket {
        text-align: center;
        margin-bottom: 2px;
    }

    .logo-img-ticket {
        width: 50px;
        height: 20px;
        object-fit: contain;
        display: block;
        margin: 0 auto 2px;
        background-color: #000;
        padding: 2px;
    }

    .company-name {
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 2px;
        text-transform: uppercase;
        color: #000;
    }

    .company-ruc {
        font-size: 9px;
        font-weight: bold;
        margin-bottom: 1px;
    }

    .company-details {
        font-size: 8px;
        line-height: 1.2;
        margin-bottom: 3px;
    }

    /* ================= DOCUMENT TITLE ================= */
    .document-title {
        font-size: 10px;
        font-weight: bold;
        text-align: center;
        margin: 5px 0;
        text-transform: uppercase;
    }

    .document-number {
        font-size: 10px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 5px;
    }

    /* ================= CLIENT INFO ================= */
    .client-section {
        margin: 4px 0;
        font-size: 9px;
    }

    .client-name {
        font-weight: bold;
        font-size: 9px;
        text-align: center;
        margin-bottom: 2px;
    }

    .client-separator {
        text-align: center;
        margin: 2px 0;
        font-size: 9px;
    }

    .client-details {
        font-size: 8px;
        margin-bottom: 3px;
        text-align: center;
    }

    /* ================= ITEMS TABLE ================= */
    .items-header {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        padding: 2px 0;
        font-size: 8px;
        font-weight: bold;
        margin: 3px 0;
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .items-header > div {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
        padding: 1px;
    }

    .header-cant { width: 15%; }
    .header-um { width: 10%; }
    .header-cod { width: 15%; }
    .header-precio { width: 25%; }
    .header-total { width: 20%; }
    .header-desc { width: 15%; }

    .items-section {
        margin: 3px 0;
        border-bottom: 1px solid #000;
        padding-bottom: 3px;
    }

    .item {
        margin-bottom: 2px;
        font-size: 8px;
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .item > div {
        display: table-cell;
        text-align: center;
        vertical-align: top;
        padding: 1px;
    }

    .item-cant { width: 15%; }
    .item-um { width: 10%; }
    .item-cod { width: 15%; }
    .item-precio { width: 25%; }
    .item-total { width: 20%; }
    .item-desc { width: 15%; }

    .item-descripcion {
        font-size: 8px;
        text-align: left;
        margin-top: 1px;
    }

    /* ================= TOTALS ================= */
    .totals-section {
        margin: 3px 0;
        font-size: 8px;
        border-top: 1px solid #000;
        padding-top: 2px;
    }

    .total-line {
        display: block;
        width: 100%;
        margin-bottom: 1px;
        font-weight: bold;
        font-size: 8px;
        line-height: 1.3;
        position: relative;
    }

    .total-text {
        display: inline-block;
        float: left;
        font-weight: bold;
    }

    .total-value {
        display: inline-block;
        float: right;
        font-weight: bold;
    }

    .total-dots {
        display: inline-block;
        float: left;
        font-weight: normal;
        letter-spacing: 0.5px;
        overflow: hidden;
        margin: 0 2px;
    }

    .total-final {
        border-top: 1px solid #000;
        padding-top: 2px;
        margin-top: 2px;
        font-size: 9px;
    }

    .total-final .total-text,
    .total-final .total-value {
        font-size: 9px;
        font-weight: bold;
    }

    /* Clear floats */
    .total-line::after {
        content: "";
        display: table;
        clear: both;
    }

    .total-letras {
        font-size: 8px;
        font-weight: bold;
        margin: 3px 0;
        text-align: left;
    }

    /* ================= PAYMENT INFO ================= */
    .payment-info {
        font-size: 8px;
        margin: 3px 0;
        text-align: left;
    }

    .payment-info div {
        margin-bottom: 1px;
    }

    /* ================= QR AND FOOTER ================= */
    .qr-section {
        text-align: center;
        margin: 5px 0;
    }

    .qr-code img {
        width: 60px;
        height: 60px;
        margin: 3px 0;
    }

    .footer-text {
        font-size: 7px;
        text-align: center;
        line-height: 1.2;
        margin: 2px 0;
    }

    .footer-url {
        font-size: 7px;
        text-align: center;
        font-weight: bold;
        margin: 2px 0;
    }

    .footer-auth {
        font-size: 6px;
        text-align: center;
        margin: 2px 0;
    }

    .powered-by {
        font-size: 6px;
        text-align: center;
        margin-top: 2px;
    }

    /* ================= UTILITIES ================= */
    .text-bold { font-weight: bold; }
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-right { text-align: right; }

    @media print {
        body { margin: 0; padding: 1px; }
    }
</style>
@endsection

@section('body-content')
<div class="container">
    @yield('content')
</div>
@endsection