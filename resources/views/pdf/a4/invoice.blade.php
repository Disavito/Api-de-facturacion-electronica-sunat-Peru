@extends('pdf.layouts.a4')

@section('content')
    {{-- Header --}}
    @include('pdf.components.header', [
        'company' => $company, 
        'document' => $document, 
        'tipo_documento_nombre' => $tipo_documento_nombre,
        'fecha_emision' => $fecha_emision,
        'format' => 'a4'
    ])

    {{-- Client Info --}}
    @include('pdf.components.client-info', [
        'client' => $client,
        'format' => 'a4',
        'fecha_emision' => $fecha_emision
    ])

    {{-- Items Table --}}
    @include('pdf.components.items-table', [
        'detalles' => $detalles,
        'format' => 'a4'
    ])

    {{-- Totals --}}
    @include('pdf.components.totals', [
        'document' => $document,
        'format' => 'a4',
        'leyendas' => $leyendas ?? []
    ])

    {{-- QR Code and Footer --}}
    @include('pdf.components.qr-footer', [
        'qr_data' => $qr_data ?? null,
        'hash_cdr' => $hash_cdr ?? null,
        'format' => 'a4'
    ])
@endsection