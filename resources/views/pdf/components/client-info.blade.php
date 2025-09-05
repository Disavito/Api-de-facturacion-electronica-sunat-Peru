{{-- PDF Client Info Component --}}
{{-- Props: $client, $format, $fecha_emision (optional) --}}

@if(in_array($format, ['a4', 'A4', 'a5', 'A5']))
    {{-- A4 Client Info --}}
    <div class="client-info">
        <div class="client-info-title">INFORMACIÓN DEL CLIENTE</div>
        <div class="client-details">
            <div class="row">
                <div class="label">Razón Social / Nombre:</div>
                <div class="value">{{ strtoupper($client['razon_social'] ?? $client['nombre'] ?? 'CLIENTE') }}</div>
            </div>
            
            @if(isset($client['numero_documento']))
                <div class="row">
                    <div class="label">{{ $client['tipo_documento'] == '6' ? 'RUC' : ($client['tipo_documento'] == '1' ? 'DNI' : 'Documento') }}:</div>
                    <div class="value">{{ $client['numero_documento'] }}</div>
                </div>
            @endif
            
            @if(isset($client['direccion']) && $client['direccion'])
                <div class="row">
                    <div class="label">Dirección:</div>
                    <div class="value">{{ $client['direccion'] }}</div>
                </div>
            @endif
            
            @if(isset($fecha_emision))
                <div class="row">
                    <div class="label">Fecha de Emisión:</div>
                    <div class="value">{{ $fecha_emision }}</div>
                </div>
            @endif
        </div>
    </div>
@else
    {{-- Ticket Client Info --}}
    <div class="client-section">
        <div class="client-row">
            <span class="client-label">CLIENTE:</span> {{ strtoupper($client['razon_social'] ?? $client['nombre'] ?? 'CLIENTE') }}
        </div>
        
        @if(isset($client['numero_documento']))
            <div class="client-row">
                <span class="client-label">{{ $client['tipo_documento'] == '6' ? 'RUC' : ($client['tipo_documento'] == '1' ? 'DNI' : 'DOC') }}:</span> {{ $client['numero_documento'] }}
            </div>
        @endif
        
        @if(isset($client['direccion']) && $client['direccion'])
            <div class="client-row break-word">
                <span class="client-label">DIR:</span> {{ $client['direccion'] }}
            </div>
        @endif
        
        @if(isset($fecha_emision))
            <div class="client-row">
                <span class="client-label">FECHA:</span> {{ $fecha_emision }}
            </div>
        @endif
    </div>
@endif