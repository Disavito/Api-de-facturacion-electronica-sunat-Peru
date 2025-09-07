{{-- PDF Dispatch Guide Footer Component --}}
{{-- Props: $document, $company, $tipo_documento_nombre, $format --}}

<div class="dispatch-footer">
    <div class="footer-info">
        <div class="additional-info">
            <strong>INFORMACIÓN ADICIONAL:</strong><br>
            • Esta guía de remisión se encuentra almacenada electrónicamente en SUNAT.<br>
            • Para verificar su autenticidad ingrese a www.sunat.gob.pe<br>
        </div>

        @if($document->codigo_hash ?? null)
            <div class="hash-section">
                <strong>CÓDIGO HASH:</strong> {{ $document->codigo_hash }}
            </div>
        @endif

        <div class="legal-text">
            Autorizado mediante resolución N° 034-005-0010431/SUNAT<br>
            Representación impresa de la {{ $tipo_documento_nombre ?? 'GUÍA DE REMISIÓN ELECTRÓNICA' }}
            
            @if($company->web ?? null)
                <br>Para consultar el comprobante visite {{ $company->web }}
            @endif
            
            @if($document->codigo_hash ?? null)
                <br>{{ $document->codigo_hash }}
            @endif
        </div>
    </div>
</div>

<style>
    .dispatch-footer {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-size: {{ $format === 'a4' ? '10px' : '8px' }};
        text-align: center;
    }

    .footer-info {
        line-height: 1.4;
    }

    .additional-info {
        margin-bottom: 10px;
        text-align: left;
    }

    .hash-section {
        margin: 8px 0;
        font-weight: bold;
        word-break: break-all;
    }

    .legal-text {
        margin-top: 10px;
        color: #666;
        line-height: 1.3;
    }

    @media print {
        .dispatch-footer {
            border: 1px solid #333;
            background-color: white;
        }
    }
</style>