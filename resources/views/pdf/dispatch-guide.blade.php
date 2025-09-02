@extends('pdf.layout')

@section('title', 'Guía de Remisión Electrónica')

@section('content')
    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <div class="company-name">{{ $company->razon_social }}</div>
            <div class="company-address">RUC: {{ $company->ruc }}</div>
            <div class="company-address">{{ $company->direccion }}</div>
            @if($company->telefono)
                <div class="company-address">Tel: {{ $company->telefono }}</div>
            @endif
            @if($company->email)
                <div class="company-address">Email: {{ $company->email }}</div>
            @endif
        </div>
        
        <div class="document-box">
            <div class="document-type">{{ $tipo_documento_nombre }}</div>
            <div class="document-number">{{ $document->numero_completo }}</div>
        </div>
    </div>

    <!-- Transport Information -->
    <div class="client-section">
        <div class="section-title">DATOS DEL TRASLADO</div>
        <div class="client-row">
            <div class="client-label">Fecha Emisión:</div>
            <div class="client-value">{{ $fecha_emision }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">Fecha Traslado:</div>
            <div class="client-value">{{ $fecha_traslado }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">Motivo Traslado:</div>
            <div class="client-value">{{ $motivo_traslado }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">Modalidad:</div>
            <div class="client-value">{{ $modalidad_traslado }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">Peso Total:</div>
            <div class="client-value">{{ $peso_total_formatted }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">N° Bultos:</div>
            <div class="client-value">{{ $document->num_bultos }}</div>
        </div>
    </div>

    <!-- Destinatario Information -->
    <div class="client-section">
        <div class="section-title">DATOS DEL DESTINATARIO</div>
        <div class="client-row">
            <div class="client-label">Razón Social:</div>
            <div class="client-value">{{ $destinatario->razon_social }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">{{ $destinatario->tipo_documento == '6' ? 'RUC:' : 'DNI:' }}</div>
            <div class="client-value">{{ $destinatario->numero_documento }}</div>
        </div>
        @if($destinatario->direccion)
        <div class="client-row">
            <div class="client-label">Dirección:</div>
            <div class="client-value">{{ $destinatario->direccion }}</div>
        </div>
        @endif
    </div>

    <!-- Addresses -->
    <div class="client-section">
        <div class="section-title">PUNTO DE PARTIDA Y LLEGADA</div>
        <div class="client-row">
            <div class="client-label">Punto Partida:</div>
            <div class="client-value">{{ $document->partida_direccion }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">Punto Llegada:</div>
            <div class="client-value">{{ $document->llegada_direccion }}</div>
        </div>
    </div>

    <!-- Transport Details -->
    @if($document->mod_traslado == '01')
    <div class="client-section">
        <div class="section-title">DATOS DEL TRANSPORTISTA</div>
        <div class="client-row">
            <div class="client-label">Razón Social:</div>
            <div class="client-value">{{ $document->transportista_razon_social }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">RUC:</div>
            <div class="client-value">{{ $document->transportista_num_doc }}</div>
        </div>
        @if($document->transportista_nro_mtc)
        <div class="client-row">
            <div class="client-label">N° MTC:</div>
            <div class="client-value">{{ $document->transportista_nro_mtc }}</div>
        </div>
        @endif
    </div>
    @endif

    @if($document->mod_traslado == '02')
    <div class="client-section">
        <div class="section-title">DATOS DEL CONDUCTOR</div>
        <div class="client-row">
            <div class="client-label">Nombres:</div>
            <div class="client-value">{{ $document->conductor_nombres }} {{ $document->conductor_apellidos }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">DNI:</div>
            <div class="client-value">{{ $document->conductor_num_doc }}</div>
        </div>
        <div class="client-row">
            <div class="client-label">Licencia:</div>
            <div class="client-value">{{ $document->conductor_licencia }}</div>
        </div>
    </div>
    @endif

    <!-- Vehicle -->
    <div class="client-section">
        <div class="section-title">DATOS DEL VEHÍCULO</div>
        <div class="client-row">
            <div class="client-label">Placa Principal:</div>
            <div class="client-value">{{ $document->vehiculo_placa }}</div>
        </div>
        @if($document->vehiculos_secundarios)
            @php $vehiculosSecundarios = is_array($document->vehiculos_secundarios) ? $document->vehiculos_secundarios : json_decode($document->vehiculos_secundarios, true) @endphp
            @if($vehiculosSecundarios)
                @foreach($vehiculosSecundarios as $index => $vehiculo)
                <div class="client-row">
                    <div class="client-label">Placa {{ $index + 2 }}:</div>
                    <div class="client-value">{{ $vehiculo['placa'] }}</div>
                </div>
                @endforeach
            @endif
        @endif
    </div>

    <!-- Details Table -->
    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 60px">CANT.</th>
                <th style="width: 80px">UNIDAD</th>
                <th style="width: 100px">CÓDIGO</th>
                <th>DESCRIPCIÓN</th>
                <th style="width: 80px">PESO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
            <tr>
                <td class="text-center">{{ number_format($detalle['cantidad'], 3) }}</td>
                <td class="text-center">{{ $detalle['unidad'] }}</td>
                <td class="text-center">{{ $detalle['codigo'] }}</td>
                <td class="text-left">{{ $detalle['descripcion'] }}</td>
                <td class="text-right">{{ number_format($detalle['peso_total'] ?? 0, 3) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Observations -->
    @if($document->observaciones)
    <div class="observations">
        <strong>OBSERVACIONES:</strong><br>
        {{ $document->observaciones }}
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div class="small">
            <strong>INFORMACIÓN ADICIONAL:</strong><br>
            - Esta guía de remisión se encuentra almacenada electrónicamente en SUNAT.<br>
            - Para verificar su autenticidad ingrese a www.sunat.gob.pe<br>
        </div>
        
        @if($document->codigo_hash)
        <div class="qr-code mt-10">
            <div class="small">Código Hash: {{ $document->codigo_hash }}</div>
        </div>
        @endif
    </div>
@endsection