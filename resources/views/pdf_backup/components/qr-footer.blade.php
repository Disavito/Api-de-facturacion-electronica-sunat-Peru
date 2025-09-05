{{-- PDF QR Code and Footer Component --}}
{{-- Props: $qr_data (optional), $hash_cdr (optional), $format --}}

@if(isset($qr_data))
    <div class="qr-section">
        {{-- QR Code generation would be handled by the QR library --}}
        <div class="qr-code">
            {{-- This would be replaced with actual QR code generation --}}
            <div style="width: {{ $format === 'a4' ? '80px' : '60px' }}; height: {{ $format === 'a4' ? '80px' : '60px' }}; border: 1px solid #ccc; text-align: center; font-size: 8px; padding: 5px;">
                QR CODE<br>
                <small>{{ Str::limit($qr_data, 20) }}</small>
            </div>
        </div>
        <div class="qr-info">
            Representación impresa del comprobante electrónico
        </div>
    </div>
@endif

@if(isset($hash_cdr) || true)
    <div class="footer">
        <div>Autorizado mediante Resolución de Superintendencia Nº 097-2012/SUNAT</div>
        <div>Representación impresa del Comprobante de Pago Electrónico</div>
        
        @if(isset($hash_cdr))
            <div class="hash-section">
                <strong>HASH CDR:</strong> {{ $hash_cdr }}
            </div>
        @endif
        
        <div class="hash-section">
            Consulte su comprobante en: {{ config('app.url', 'https://mi-empresa.com') }}
        </div>
    </div>
@endif