{{-- PDF Header Component --}}
{{-- Props: $company, $document, $tipo_documento_nombre, $fecha_emision, $format --}}

@if($format === 'a4')
    {{-- A4 Header --}}
    <div class="header">
        <div class="logo-section">
            @if(isset($company->logo_path) && $company->logo_path)
                <img src="{{ $company->logo_path }}" alt="Logo">
            @endif
        </div>
        
        <div class="company-section">
            <div class="company-name">{{ strtoupper($company->razon_social ?? 'EMPRESA') }}</div>
            <div class="company-details">
                @if($company->nombre_comercial)
                    <strong>{{ $company->nombre_comercial }}</strong><br>
                @endif
                <strong>RUC:</strong> {{ $company->ruc ?? '' }}<br>
                <strong>Dirección:</strong> {{ $company->direccion ?? '' }}<br>
                @if($company->telefono)
                    <strong>Teléfono:</strong> {{ $company->telefono }}<br>
                @endif
                @if($company->email)
                    <strong>Email:</strong> {{ $company->email }}
                @endif
            </div>
        </div>
        
        <div class="document-section">
            <div class="document-title">{{ strtoupper($tipo_documento_nombre) }}</div>
            <div class="document-number">{{ $document->numero_completo }}</div>
            <div class="document-date">{{ $fecha_emision }}</div>
        </div>
    </div>
@else
    {{-- Ticket Header --}}
    <div class="header">
        <div class="company-name">{{ strtoupper($company->razon_social ?? 'EMPRESA') }}</div>
        <div class="company-details">
            @if($company->nombre_comercial)
                {{ $company->nombre_comercial }}<br>
            @endif
            RUC: {{ $company->ruc ?? '' }}<br>
            {{ $company->direccion ?? '' }}<br>
            @if($company->telefono)
                Tel: {{ $company->telefono }}<br>
            @endif
            @if($company->email)
                Email: {{ $company->email }}
            @endif
        </div>
        
        <div class="document-info">
            <div>{{ strtoupper($tipo_documento_nombre) }}</div>
            <div>{{ $document->numero_completo }}</div>
            <div>{{ $fecha_emision }}</div>
        </div>
    </div>
@endif