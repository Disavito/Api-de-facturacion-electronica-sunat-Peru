@extends('pdf.layouts.50mm')

@section('content')
    {{-- Header --}}
    @include('pdf.components.header', [
        'company' => $company, 
        'document' => $document, 
        'tipo_documento_nombre' => $tipo_documento_nombre,
        'fecha_emision' => $fecha_emision,
        'format' => '50mm'
    ])

    {{-- Reference Document --}}
    @include('pdf.components.reference-document', [
        'documento_afectado' => $documento_afectado,
        'motivo' => $motivo,
        'format' => '50mm'
    ])

    {{-- Client Info --}}
    @include('pdf.components.client-info', [
        'client' => $client,
        'format' => '50mm',
        'fecha_emision' => $fecha_emision
    ])

    {{-- Items Table --}}
    @include('pdf.components.items-table', [
        'detalles' => $detalles,
        'format' => '50mm'
    ])

    {{-- Totals --}}
    @include('pdf.components.totals', [
        'document' => $document,
        'format' => '50mm',
        'leyendas' => $leyendas ?? []
    ])

    {{-- QR Code and Footer --}}
    @include('pdf.components.qr-footer', [
        'qr_data' => $qr_data ?? null,
        'hash_cdr' => $hash_cdr ?? null,
        'format' => '50mm'
    ])
@endsection