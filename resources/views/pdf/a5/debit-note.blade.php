@extends('pdf.layouts.a5')

@section('content')
    {{-- Header --}}
    @include('pdf.components.header', [
        'company' => $company, 
        'document' => $document, 
        'tipo_documento_nombre' => $tipo_documento_nombre,
        'fecha_emision' => $fecha_emision,
        'format' => 'a5'
    ])

    {{-- Reference Document --}}
    @include('pdf.components.reference-document', [
        'documento_afectado' => $documento_afectado,
        'motivo' => $motivo,
        'format' => 'a5'
    ])

    {{-- Client Info --}}
    @include('pdf.components.client-info', [
        'client' => $client,
        'format' => 'a5',
        'fecha_emision' => $fecha_emision
    ])

    {{-- Items Table --}}
    @include('pdf.components.items-table', [
        'detalles' => $detalles,
        'format' => 'a5'
    ])

    {{-- Totals --}}
    @include('pdf.components.totals', [
        'document' => $document,
        'format' => 'a5',
        'leyendas' => $leyendas ?? []
    ])

    {{-- QR Code and Footer --}}
    @include('pdf.components.qr-footer', [
        'qr_data' => $qr_data ?? null,
        'hash_cdr' => $hash_cdr ?? null,
        'format' => 'a5'
    ])
@endsection