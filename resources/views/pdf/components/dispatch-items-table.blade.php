{{-- PDF Dispatch Items Table Component --}}
{{-- Props: $detalles, $format --}}

@if(in_array($format, ['a4', 'A4', 'a5', 'A5']))
    {{-- A4/A5 Dispatch Items Table --}}
    <table class="items-table">
        <thead>
            <tr>
                <th>Nº</th>
                <th>CÓDIGO</th>
                <th>DESCRIPCIÓN</th>
                <th>UNIDAD</th>
                <th>CANT.</th>
                <th>PESO UNIT.</th>
                <th>PESO TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detalles as $index => $detalle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detalle['codigo_interno'] ?? $detalle['codigo'] ?? '' }}</td>
                    <td>{{ $detalle['descripcion'] ?? 'PRODUCTO' }}</td>
                    <td>{{ $detalle['unidad'] ?? 'NIU' }}</td>
                    <td>{{ number_format($detalle['cantidad'] ?? 0, 2) }}</td>
                    <td>{{ number_format($detalle['peso_unitario'] ?? 0, 3) }} KGM</td>
                    <td>{{ number_format($detalle['peso_total'] ?? 0, 3) }} KGM</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">No hay items en esta guía de remisión</td>
                </tr>
            @endforelse
            
            {{-- Spacer row for remaining space --}}
            @if(count($detalles) < 10)
                @for($i = count($detalles); $i < 10; $i++)
                    <tr class="spacer-row">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>
@else
    {{-- Ticket Dispatch Items Table --}}
    <table class="items-table">
        <thead>
            <tr>
                <th class="col-codigo">Cód.</th>
                <th class="col-descripcion">Descripción</th>
                <th class="col-cantidad">Cant.</th>
                <th class="col-peso">Peso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td class="text-center">{{ $detalle['codigo_interno'] ?? $detalle['codigo'] ?? '-' }}</td>
                    <td class="text-left">{{ Str::limit($detalle['descripcion'] ?? '', 25) }}</td>
                    <td class="text-center">{{ number_format($detalle['cantidad'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($detalle['peso_total'] ?? 0, 3) }} KGM</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif