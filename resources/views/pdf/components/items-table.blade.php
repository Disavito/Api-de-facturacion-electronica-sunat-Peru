{{-- PDF Items Table Component --}}
{{-- Props: $detalles, $format --}}

@if(in_array($format, ['a4', 'A4', 'a5', 'A5']))
    {{-- A4 Items Table --}}
    <table class="items-table table table-bordered-dark">
        <thead>
            <tr>
                <th class="col-codigo">Código</th>
                <th class="col-descripcion">Descripción</th>
                <th class="col-cantidad">Cant.</th>
                <th class="col-unidad">Unid.</th>
                <th class="col-precio">P. Unit.</th>
                <th class="col-descuento">Desc.</th>
                <th class="col-subtotal">Subtotal</th>
                <th class="col-igv">IGV</th>
                <th class="col-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td class="text-center">{{ $detalle['codigo'] ?? '-' }}</td>
                    <td class="text-left">{{ $detalle['descripcion'] ?? '' }}</td>
                    <td class="text-center">{{ number_format($detalle['cantidad'] ?? 0, 2) }}</td>
                    <td class="text-center">{{ $detalle['unidad'] ?? 'NIU' }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['descuento'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_valor_venta'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_igv'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_precio_unitario'] ?? $detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    {{-- Ticket Items Table --}}
    <table class="items-table">
        <thead>
            <tr>
                <th class="col-codigo">Cód.</th>
                <th class="col-descripcion">Descripción</th>
                <th class="col-cantidad">Cant.</th>
                <th class="col-precio">P. Unit.</th>
                <th class="col-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td class="text-center">{{ $detalle['codigo'] ?? '-' }}</td>
                    <td class="text-left">{{ Str::limit($detalle['descripcion'] ?? '', 20) }}</td>
                    <td class="text-center">{{ number_format($detalle['cantidad'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['mto_precio_unitario'] ?? $detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif