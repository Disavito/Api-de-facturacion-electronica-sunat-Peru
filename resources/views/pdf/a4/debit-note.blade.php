<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Nota de Débito Electrónica</title>
  <style>
    /* ================= BASE ================= */
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 18cm;
      margin: auto;
      padding: 15px;
      box-sizing: border-box;
      border: 1px solid #000;
      border-radius: 10px;
    }

    /* ================= HEADER ================= */
    .header {
      display: table;
      width: 97%;
      border-bottom: 1px solid #000;
      padding-bottom: 15px;
      table-layout: fixed;
    }

    .header > div {
      display: table-cell;
      vertical-align: top;
      padding: 5px;
    }

    .logo {
      width: 25%;
      text-align: left;
    }

    .logo img {
      width: 60px;
      height: 60px;
      object-fit: contain;
      vertical-align: top;
      margin-right: 10px;
    }

    .empresa {
      width: 50%;
      text-align: left;
      padding: 0 15px;
    }

    .empresa h2 {
      margin: 0 0 5px 0;
      font-size: 16px;
      font-weight: bold;
      color: #000;
    }

    .empresa p {
      line-height: 1.4;
      margin: 0;
      font-size: 11px;
      color: #333;
    }

    .factura {
      width: 25%;
      text-align: center;
      vertical-align: top;
    }

    .factura-box {
      border: 1px solid #000;
      border-radius: 8px;
      padding: 10px;
      font-size: 11px;
      background-color: #fff;
      display: inline-block;
      min-width: 180px;
    }

    .factura-box p {
      margin: 2px 0;
      font-weight: bold;
    }

    /* ================= DATOS ================= */
    .datos {
      margin-top: 15px;
      margin-bottom: 15px;
      display: table;
      width: 100%;
      font-size: 12px;
      table-layout: fixed;
    }

    .datos > div {
      display: table-cell;
      width: 50%;
      vertical-align: top;
      padding: 5px;
    }

    .datos p {
      line-height: 1.6;
      margin: 0;
      padding: 5px 0;
    }

    /* ================= DOCUMENTO AFECTADO ================= */
    .doc-afectado {
      margin-top: 15px;
      margin-bottom: 15px;
      padding: 10px;
      border: 2px solid #ff9800;
      border-radius: 8px;
      background-color: #fff8e1;
    }

    .doc-afectado h3 {
      margin: 0 0 10px 0;
      color: #ff9800;
      font-size: 13px;
      text-align: center;
    }

    .doc-afectado .info {
      display: table;
      width: 100%;
    }

    .doc-afectado .info > div {
      display: table-cell;
      width: 33.33%;
      text-align: center;
      padding: 5px;
    }

    /* ================= TABLA PRINCIPAL ================= */
    table {
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
      font-size: 11px;
      border: 1px solid #000;
      border-radius: 8px;
    }

    /* Tabla de items sin altura fija */
    table:not(.en-letras):not(.totales) {
      width: 100%;
    }

    /* Fila espaciadora completamente dinámica */
    .fila-espaciadora td {
      height: 350px;
      vertical-align: top;
      border-bottom: none;
      padding: 0;
    }

    thead {
      background-color: #f0f0f0;
    }

    th,
    td {
      border-right: 1px solid #000;
      border-bottom: 1px solid #000;
      padding: 5px;
      text-align: left;
    }

    /* Primera columna sin borde izquierdo */
    th:first-child,
    td:first-child {
      border-left: none;
    }

    /* Última columna sin borde derecho */
    th:last-child,
    td:last-child {
      border-right: none;
    }

    /* Última fila sin borde inferior */
    tbody tr:last-child td {
      border-bottom: none;
    }

    /* Header sin borde superior (ya lo tiene la tabla) */
    thead th:first-child {
      border-top: none;
    }
    
    thead th:last-child {
      border-top: none;
    }
    
    thead th {
      border-top: none;
    }

    /* Esquinas redondeadas para el header */
    thead th:first-child {
      border-top-left-radius: 6px;
    }

    thead th:last-child {
      border-top-right-radius: 6px;
    }

    /* Esquinas redondeadas para la última fila */
    tbody tr:last-child td:first-child {
      border-bottom-left-radius: 6px;
    }

    tbody tr:last-child td:last-child {
      border-bottom-right-radius: 6px;
    }

    /* Columnas numéricas alineadas a la derecha */
    th:nth-child(5),
    th:nth-child(6),
    td:nth-child(5),
    td:nth-child(6) {
      text-align: right;
    }

    /* ================= SON EN LETRAS ================= */
    .en-letras {
      margin-top: 5px;
    }

    .en-letras td {
      text-align: center;
      font-weight: bold;
      padding: 6px;
      font-size: 11px;
    }

    /* ================= TOTALES ================= */
    .totales {
      margin-top: 10px;
    }

    .totales td {
      padding: 2px 10px;
      font-size: 11px;
      vertical-align: top;
      line-height: 1.2;
    }

    .totales .label {
      text-align: right;
      font-weight: bold;
      width: 150px;
    }

    .totales .resaltado {
      background: #f0f0f0;
      font-weight: bold;
    }

    /* Reducir espacio entre filas de totales */
    .totales tr {
      height: auto;
    }

    .totales tr td {
      border-bottom: none;
    }

    /* Info + QR en misma celda */
    .qr-info-container {
      display: table;
      width: 100%;
      table-layout: fixed;
    }

    .qr {
      display: table-cell;
      width: 130px;
      vertical-align: top;
      text-align: center;
      padding-right: 10px;
    }

    .qr img {
      width: 100px;
      height: 100px;
      display: block;
      margin: 0 auto;
    }

    .info-footer {
      display: table-cell;
      font-size: 10px;
      text-align: left;
      vertical-align: top;
      padding-left: 10px;
      line-height: 1.4;
    }

    /* ================= FOOTER EXTRA ================= */
    .footer-extra {
      margin-top: 20px;
      padding: 15px;
      border: 1px solid #000;
      border-radius: 8px;
      background-color: #f9f9f9;
    }

    /* ================= PRINT ================= */
    @media print {
      body {
        margin: 0;
      }

      .container {
        border: none;
        padding: 0;
      }
    }
  </style>
</head>

<body>
  <div class="container">

    <!-- HEADER -->
    <div class="header">
      <div class="logo">
        @if($company->logo_path)
        <img src="{{ $company->logo_path }}" alt="Logo {{ $company->razon_social }}">
        @else
        <img src="./logo.jpg" alt="Logo Empresa">
        @endif
      </div>
      <div class="empresa">
        <h2>{{ $company->razon_social ?? 'RAZÓN SOCIAL DE LA EMPRESA' }}</h2>
        <p>
          <strong>Dirección:</strong> {{ $company->direccion ?? 'Dirección de la empresa' }}<br>
          @if($company->telefono ?? null)
          <strong>Teléfono:</strong> {{ $company->telefono ?? 'N/A' }}<br>
          @endif
          @if($company->email ?? null)
          <strong>Email:</strong> {{ $company->email ?? 'N/A' }}<br>
          @endif
          @if($company->web ?? null)
          <strong>Web:</strong> {{ $company->web ?? 'N/A' }}
          @endif
        </p>
      </div>
      <div class="factura">
        <div class="factura-box">
          <p><b>RUC {{ $company->ruc ?? '20000000001' }}</b></p>
          <p><b>NOTA DE DÉBITO ELECTRÓNICA</b></p>
          <p><b>{{ $document->numero_completo ?? 'FD01-00000001' }}</b></p>
        </div>
      </div>
    </div>

    <!-- DOCUMENTO AFECTADO -->
    <div class="doc-afectado">
      <h3>DOCUMENTO AFECTADO POR LA NOTA DE DÉBITO</h3>
      <div class="info">
        <div>
          <strong>TIPO:</strong> {{ $documento_afectado['tipo'] ?? 'FACTURA' }}
        </div>
        <div>
          <strong>NÚMERO:</strong> {{ $documento_afectado['numero'] ?? 'N/A' }}
        </div>
        <div>
          <strong>MOTIVO:</strong> {{ $motivo['descripcion'] ?? 'INTERESES POR MORA' }}
        </div>
      </div>
    </div>

    <!-- DATOS -->
    <div class="datos">
      <div>
        <p>
          <b>{{ ($client['tipo_documento'] ?? '1') == '6' ? 'RUC' : 'DNI' }}:</b> {{ $client['numero_documento'] ?? '' }}<br>
          <b>CLIENTE:</b> {{ $client['razon_social'] ?? 'CLIENTE' }}<br>
          @if(!empty($client['direccion'] ?? ''))
          <b>DIRECCIÓN:</b> {{ $client['direccion'] }}
          @endif
        </p>
      </div>
      <div>
        <p>
          <b>FECHA EMISIÓN:</b> {{ $fecha_emision ?? '' }}<br>
          <b>MONEDA:</b> {{ $totales['moneda_nombre'] ?? 'SOLES' }}
        </p>
      </div>
    </div>

    <!-- TABLA DE ITEMS -->
    <table>
      <thead>
        <tr>
          <th>Nº</th>
          <th>CÓDIGO</th>
          <th>DESCRIPCIÓN</th>
          <th>UNIDAD</th>
          <th>CANT.</th>
          <th>P. UNIT.</th>
          <th>TOTAL</th>
        </tr>
      </thead>
      <tbody>
        @if(is_array($detalles ?? []) && count($detalles) > 0)
                    @foreach($detalles as $index => $detalle)
        <tr>
          <td>{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
          <td>{{ $detalle['codigo_interno'] ?? $detalle['codigo'] ?? '' }}</td>
          <td>{{ $detalle['descripcion'] ?? 'INTERESES POR MORA' }}</td>
          <td>{{ $detalle['unidad'] ?? 'NIU' }}</td>
          <td>{{ number_format($detalle['cantidad'] ?? 0, 2) }}</td>
          <td>{{ number_format($detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
          <td>{{ number_format($detalle['mto_valor_venta'] ?? 0, 2) }}</td>
        </tr>
            @endforeach
        @endif
        
        <!-- Fila espaciadora dinámica -->
        <tr class="fila-espaciadora">
          <td colspan="7">&nbsp;</td>
        </tr>
      </tbody>
    </table>

    <!-- SON EN LETRAS -->
    <table class="en-letras">
      <tr>
        <td>SON: {{ strtoupper(app('App\Services\PdfService')->numeroALetras($totales['total'] ?? 0)) }} {{ strtoupper($totales['moneda_nombre'] ?? 'SOLES') }}</td>
      </tr>
    </table>

    <!-- TOTALES -->
    <table class="totales">
      <tr>
        <td rowspan="7" style="width: 60%;">
          <div class="qr-info-container">
            <div class="qr">
              @if(isset($document->codigo_hash))
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($document->codigo_hash) }}" alt="Código QR">
              @else
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($document->numero_completo ?? 'Document') }}" alt="Código QR">
              @endif
            </div>
            <div class="info-footer">
              <b>OBSERVACIONES:</b><br>
              • Esta nota de débito se encuentra almacenada electrónicamente en SUNAT.<br>
              • Para verificar su autenticidad ingrese a www.sunat.gob.pe<br>
              @if($document->observaciones ?? null)
              • {{ $document->observaciones }}<br>
              @endif
              <br>

             @if($document->codigo_hash ?? null)
            <div style="margin-top: 8px; padding: 4px; background: #f0f0f0; font-size: 8px; word-break: break-all;">
                <strong>CÓDIGO HASH:</strong> {{ $document->codigo_hash }}
            </div>
            @endif
            </div>
          </div>
        </td>
        <td class="label">Total Ope. Gravadas</td>
        <td>{{ $totales['subtotal_formatted'] ?? '0.00' }}</td>
      </tr>
      <tr>
        <td class="label">Total Ope. Inafectadas</td>
        <td>S/ 0.00</td>
      </tr>
      <tr>
        <td class="label">Total Ope. Exoneradas</td>
        <td>S/ 0.00</td>
      </tr>
      <tr>
        <td class="label">Total Descuentos</td>
        <td>S/ 0.00</td>
      </tr>
      <tr>
        <td class="label">Total IGV</td>
        <td>{{ $totales['igv_formatted'] ?? '0.00' }}</td>
      </tr>
      <tr>
        <td class="label">Total ISC</td>
        <td>S/ 0.00</td>
      </tr>
      <tr>
        <td class="label resaltado">TOTAL A PAGAR</td>
        <td class="resaltado">{{ $totales['total_formatted'] ?? '0.00' }}</td>
      </tr>
    </table>
    
    <!-- CONTENIDO EXTRA AL FINAL -->
    <div class="footer-extra">
         Autorizado mediante resolución N° 034-005-0010431/SUNAT
              Representación impresa de la NOTA DE DÉBITO ELECTRÓNICA
              Para consultar el comprobante visite www.sunat.gob.pe
    </div>

  </div>
</body>
</html>