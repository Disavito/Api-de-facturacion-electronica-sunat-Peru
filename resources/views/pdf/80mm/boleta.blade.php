@extends('pdf.layouts.80mm')

@section('content')
    {{-- Header --}}
    @include('pdf.components.header', [
        'company' => $company, 
        'document' => $document, 
        'tipo_documento_nombre' => $tipo_documento_nombre,
        'fecha_emision' => $fecha_emision,
        'format' => '80mm'
    ])

    {{-- Client Info --}}
    @include('pdf.components.client-info', [
        'client' => $client,
        'format' => '80mm',
        'fecha_emision' => $fecha_emision
    ])

    {{-- Items Table --}}
    @include('pdf.components.items-table', [
        'detalles' => $detalles,
        'format' => '80mm'
    ])

    {{-- Totals --}}
    @include('pdf.components.totals', [
        'document' => $document,
        'format' => '80mm',
        'leyendas' => $leyendas ?? []
    ])

    {{-- QR Code and Footer --}}
    @include('pdf.components.qr-footer', [
        'qr_data' => $qr_data ?? null,
        'hash_cdr' => $hash_cdr ?? null,
        'format' => '80mm'
    ])
@endsection