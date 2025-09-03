@extends('pdf.80mm.layout')

@section('content')
    <div class="ticket">
        {{-- Logo --}}
        @if (isset($company->logo_path) && $company->logo_path)
            <img src="{{ $company->logo_path }}" alt="logo" class="logo">
        @else
            <img src="https://via.placeholder.com/150" alt="logo" class="logo">
        @endif

        {{-- Company Info --}}
        <div class="text-center">
            <p class="company-name">{{ strtoupper($company->razon_social ?? 'NOMBRE DE LA EMPRESA') }}</p>
            <p>RUC: {{ $company->ruc ?? '12345678901' }}</p>
            <p>{{ $company->direccion ?? 'DIRECCIÓN DE LA EMPRESA' }}</p>
            @if (isset($company->telefono))
                <p>CONTRATOS: {{ $company->telefono }}</p>
            @endif
            @if (isset($company->email))
                <p>CORREO: {{ strtoupper($company->email) }}</p>
            @endif
        </div>

        {{-- Document Info --}}
        <div class="document-info">
            <p class="document-title">{{ strtoupper($tipo_documento_nombre) }}</p>
            <p>{{ $document->numero_completo }}</p>
        </div>

        {{-- Client Info --}}
        <div class="client-info">
            <table>
                <tr>
                    <td><strong>CLIENTE</strong></td>
                    <td>: {{ strtoupper($client['razon_social'] ?? 'CLIENTE VARIOS') }}</td>
                </tr>
                <tr>
                    <td><strong>{{ $client['tipo_documento'] == '6' ? 'RUC' : 'DNI' }}</strong></td>
                    <td>: {{ $client['numero_documento'] }}</td>
                </tr>
                <tr>
                    <td><strong>FECHA</strong></td>
                    <td>: {{ $fecha_emision }}</td>
                </tr>
            </table>
        </div>

        {{-- Items Table --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th class="text-center">Cant.</th>
                    <th class="text-right">P. Unit</th>
                    <th class="text-right">Importe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $detalle)
                    <tr>
                        <td>{{ $detalle['codigo'] ?? '' }}</td>
                        <td>{{ strtoupper($detalle['descripcion']) }}</td>
                        <td class="text-center">{{ number_format($detalle['cantidad'], 2) }}</td>
                        <td class="text-right">{{ number_format($detalle['mto_valor_unitario'], 2) }}</td>
                        <td class="text-right">{{ number_format($detalle['mto_valor_venta'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="totals">
            <table class="totals-table">
                <tr>
                    <td><strong>SUB TOTAL</strong></td>
                    <td class="text-right">PEN {{ $totales['subtotal_formatted'] }}</td>
                </tr>
                <tr>
                    <td><strong>I.G.V.</strong></td>
                    <td class="text-right">PEN {{ $totales['igv_formatted'] }}</td>
                </tr>
                <tr>
                    <td><strong>TOTAL VENTA</strong></td>
                    <td class="text-right">PEN {{ $totales['total_formatted'] }}</td>
                </tr>
            </table>
        </div>

        {{-- Additional Info --}}
        <div class="additional-info">
            @if (isset($document->adelanto) && $document->adelanto > 0)
                <div class="section">
                    <p class="section-title">Adelanto y Saldo</p>
                    <p>Adelanto de S/ {{ number_format($document->adelanto, 2) }}</p>
                    <p>Saldo de S/ {{ number_format($totales['total'] - $document->adelanto, 2) }}</p>
                </div>
            @endif

            @if (isset($company->cuentas_bancarias) && count($company->cuentas_bancarias) > 0)
                <div class="section">
                    <p class="section-title">Cuentas Bancarias</p>
                    @foreach ($company->cuentas_bancarias as $cuenta)
                        <p>{{ $cuenta['banco'] }}: {{ $cuenta['numero_cuenta'] }}</p>
                        @if (isset($cuenta['cci']))
                            <p>{{ $cuenta['banco'] }} CCI: {{ $cuenta['cci'] }}</p>
                        @endif
                    @endforeach
                </div>
            @endif

            @if (isset($company->condiciones) && count($company->condiciones) > 0)
                <div class="section">
                    <p class="section-title">Condiciones</p>
                    @foreach ($company->condiciones as $condicion)
                        <p>* {{ $condicion }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>Representación impresa de la {{ $tipo_documento_nombre ?? 'FACTURA ELECTRÓNICA' }}</p>
            @if (isset($document->codigo_hash))
                <p class="hash">Hash: {{ $document->codigo_hash }}</p>
            @endif
            <p>Consulte su documento en {{ $company->website ?? 'nuestro sitio web' }}</p>
        </div>
    </div>
@endsection
