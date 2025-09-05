@extends('pdf.layouts.ticket')

@section('content')
    {{-- Header --}}
    @include('pdf.components.header', [
        'company' => $company, 
        'document' => $document, 
        'tipo_documento_nombre' => $tipo_documento_nombre,
        'fecha_emision' => $fecha_emision,
        'format' => 'ticket'
    ])

    {{-- Client Info --}}
    @include('pdf.components.client-info', [
        'client' => $client,
        'format' => 'ticket',
        'fecha_emision' => $fecha_emision
    ])

    {{-- Items Table --}}
    @include('pdf.components.items-table', [
        'detalles' => $detalles,
        'format' => 'ticket'
    ])

    {{-- Totals --}}
    @include('pdf.components.totals', [
        'document' => $document,
        'format' => 'ticket'
    ])

    {{-- Additional Info for Tickets --}}
    @if(isset($leyendas) && !empty($leyendas))
        <div class="additional-info">
            @foreach($leyendas as $leyenda)
                <div class="section">
                    <div class="section-title">{{ $leyenda['codigo'] ?? '' }}:</div>
                    <div>{{ $leyenda['descripcion'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- QR Code and Footer --}}
    @include('pdf.components.qr-footer', [
        'qr_data' => $qr_data ?? null,
        'hash_cdr' => $hash_cdr ?? null,
        'format' => 'ticket'
    ])
@endsection