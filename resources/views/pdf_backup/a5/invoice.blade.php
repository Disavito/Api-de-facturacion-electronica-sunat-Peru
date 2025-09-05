<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>{{ $tipo_documento_nombre }}</title>
  <style>
    /* ================= BASE ================= */
    body {
      font-family: Arial, sans-serif;
      font-size: 9px;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 13cm;
      margin: auto;
      padding: 10px;
      box-sizing: border-box;
      border: 1px solid #000;
      border-radius: 8px;
    }

    /* ================= HEADER ================= */
    .header {
      display: table;
      width: 97%;
      border-bottom: 1px solid #000;
      padding-bottom: 10px;
      table-layout: fixed;
    }

    .header > div {
      display: table-cell;
      vertical-align: top;
      padding: 3px;
    }

    .logo {
      width: 25%;
      text-align: left;
    }

    .logo img {
      width: 45px;
      height: 45px;
      object-fit: contain;
      vertical-align: top;
      margin-right: 6px;
    }

    .empresa {
      width: 50%;
      text-align: left;
      padding: 0 10px;
    }

    .empresa h2 {
      margin: 0 0 3px 0;
      font-size: 12px;
      font-weight: bold;
      color: #000;
    }

    .empresa p {
      line-height: 1.3;
      margin: 0;
      font-size: 8px;
      color: #333;
    }

    .factura {
      width: 25%;
      text-align: center;
      vertical-align: top;
    }

    .factura-box {
      border: 1px solid #000;
      border-radius: 6px;
      padding: 6px;
      font-size: 8px;
      background-color: #fff;
      display: inline-block;
      min-width: 120px;
    }

    .factura-box p {
      margin: 1px 0;
      font-weight: bold;
    }

    /* ================= DATOS ================= */
    .datos {
      margin-top: 10px;
      margin-bottom: 10px;
      display: table;
      width: 100%;
      font-size: 9px;
      table-layout: fixed;
    }

    .datos > div {
      display: table-cell;
      width: 50%;
      vertical-align: top;
      padding: 3px;
    }

    .datos p {
      line-height: 1.4;
      margin: 0;
      padding: 3px 0;
    }

    /* ================= TABLA PRINCIPAL ================= */
    table {
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
      font-size: 8px;
      border: 1px solid #000;
      border-radius: 6px;
    }

    /* Tabla de items sin altura fija */
    table:not(.en-letras):not(.totales) {
      width: 100%;
    }

    /* Fila espaciadora completamente dinámica */
    .fila-espaciadora td {
      height: 300px;
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
      padding: 3px;
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
      border-top-left-radius: 4px;
    }

    thead th:last-child {
      border-top-right-radius: 4px;
    }

    /* Esquinas redondeadas para la última fila */
    tbody tr:last-child td:first-child {
      border-bottom-left-radius: 4px;
    }

    tbody tr:last-child td:last-child {
      border-bottom-right-radius: 4px;
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
      margin-top: 4px;
    }

    .en-letras td {
      text-align: center;
      font-weight: bold;
      padding: 4px;
      font-size: 8px;
    }

    /* ================= TOTALES ================= */
    .totales {
      margin-top: 8px;
    }

    .totales td {
      padding: 2px 6px;
      font-size: 8px;
      vertical-align: top;
      line-height: 1.2;
    }

    .totales .label {
      text-align: right;
      font-weight: bold;
      width: 100px;
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
      width: 80px;
      vertical-align: top;
      text-align: center;
      padding-right: 6px;
    }

    .qr img {
      width: 70px;
      height: 70px;
      display: block;
      margin: 0 auto;
    }

    .info-footer {
      display: table-cell;
      font-size: 7px;
      text-align: left;
      vertical-align: top;
      padding-left: 6px;
      line-height: 1.3;
    }

    /* ================= FOOTER EXTRA ================= */
    .footer-extra {
      margin-top: 12px;
      padding: 8px;
      border: 1px solid #000;
      border-radius: 6px;
      background-color: #f9f9f9;
      font-size: 7px;
      text-align: center;
      line-height: 1.3;
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
        <h2>{{ $company->razon_social ?? 'EMPRESA' }}</h2>
        <p>
          @if($company->direccion)
            {{ $company->direccion }}<br>
          @endif
          @if($company->distrito || $company->provincia || $company->departamento)
            {{ $company->distrito ? $company->distrito . ', ' : '' }}{{ $company->provincia ? $company->provincia . ', ' : '' }}{{ $company->departamento }}<br>
          @endif
          @if($company->telefono)
            TEL: {{ $company->telefono }}<br>
          @endif
          @if($company->email)
            {{ $company->email }}<br>
          @endif
          @if($company->web)
            {{ $company->web }}
          @endif
        </p>
      </div>
      <div class="factura">
        <div class="factura-box">
          <p><b>RUC {{ $company->ruc ?? 'N/A' }}</b></p>
          <p><b>{{ $tipo_documento_nombre ?? 'FACTURA ELECTRÓNICA' }}</b></p>
          <p><b>{{ $document->serie }}-{{ str_pad($document->correlativo, 6, '0', STR_PAD_LEFT) }}</b></p>
        </div>
      </div>
    </div>

    <!-- DATOS -->
    <div class="datos">
      <div>
        <p>
          <b>{{ $client['tipo_documento'] == '6' ? 'RUC' : 'DNI' }}:</b> {{ $client['numero_documento'] ?? 'N/A' }}<br>
          <b>CLIENTE:</b> {{ $client['razon_social'] ?? 'CLIENTE' }}<br>
          @if(isset($client['direccion']) && $client['direccion'])
            <b>DIRECCIÓN:</b> {{ $client['direccion'] }}
          @endif
        </p>
      </div>
      <div>
        <p>
          <b>FECHA EMISIÓN:</b> {{ $fecha_emision }}<br>
          <b>FECHA VENCIMIENTO:</b> {{ $fecha_vencimiento ?? '-' }}<br>
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
          <th>UND</th>
          <th>CANT.</th>
          <th>P.UNIT</th>
          <th>TOTAL</th>
        </tr>
      </thead>
      <tbody>
        @forelse($detalles as $index => $detalle)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $detalle['codigo'] ?? '' }}</td>
            <td>{{ $detalle['descripcion'] ?? '' }}</td>
            <td>{{ $detalle['unidad'] ?? 'NIU' }}</td>
            <td>{{ number_format($detalle['cantidad'] ?? 0, 2) }}</td>
            <td>{{ number_format($detalle['mto_valor_unitario'] ?? 0, 2) }}</td>
            <td>{{ number_format($detalle['mto_valor_venta'] ?? 0, 2) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align: center; padding: 15px;">No hay items en esta factura</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <!-- SON EN LETRAS -->
    <table class="en-letras">
      <tr>
        <td>SON: {{ strtoupper($total_en_letras) }} {{ strtoupper($totales['moneda_nombre'] ?? 'SOLES') }}</td>
      </tr>
    </table>

    <!-- TOTALES -->
    <table class="totales">
      <tr>
        <td rowspan="7" style="width: 60%;">
          <div class="qr-info-container">
            <div class="qr">
              <img src="{{ $qr_code }}" alt="Código QR">
            </div>
            <div class="info-footer">
              <b>FECHA EMISIÓN:</b> {{ $fecha_emision }}<br>
              <b>CONDICIÓN PAGO:</b> {{ $document->forma_pago_tipo ?? 'CONTADO' }}<br>
              @if(!empty($document->observaciones))
                <b>OBSERVACIONES:</b> {{ $document->observaciones }}<br>
              @endif
              @if(!empty($document->leyendas))
                <b>LEYENDAS:</b><br>
                @php
                    $leyendas = is_array($document->leyendas) ? $document->leyendas : json_decode($document->leyendas, true);
                    $leyendas = $leyendas ?? [];
                @endphp
                @foreach($leyendas as $leyenda)
                  • {{ $leyenda['value'] ?? '' }}<br>
                @endforeach
              @endif
              @if($hash)
                <b>HASH:</b> {{ substr($hash, 0, 15) }}...<br>
              @endif
            </div>
          </div>
        </td>
        <td class="label">Ope. Gravadas</td>
        <td>{{ $totales['moneda'] }} {{ $totales['subtotal_formatted'] }}</td>
      </tr>
      <tr>
        <td class="label">Ope. Inafectadas</td>
        <td>{{ $totales['moneda'] }} {{ number_format($document->mto_oper_inafectas ?? 0, 2) }}</td>
      </tr>
      <tr>
        <td class="label">Ope. Exoneradas</td>
        <td>{{ $totales['moneda'] }} {{ number_format($document->mto_oper_exoneradas ?? 0, 2) }}</td>
      </tr>
      <tr>
        <td class="label">Descuentos</td>
        <td>{{ $totales['moneda'] }} 0.00</td>
      </tr>
      <tr>
        <td class="label">IGV</td>
        <td>{{ $totales['moneda'] }} {{ $totales['igv_formatted'] }}</td>
      </tr>
      <tr>
        <td class="label">ISC</td>
        <td>{{ $totales['moneda'] }} {{ number_format($document->mto_isc ?? 0, 2) }}</td>
      </tr>
      <tr>
        <td class="label resaltado">TOTAL A PAGAR</td>
        <td class="resaltado">{{ $totales['moneda'] }} {{ $totales['total_formatted'] }}</td>
      </tr>
    </table>
    
    <!-- CONTENIDO EXTRA AL FINAL -->
    <div class="footer-extra">
      Autorizado mediante Resolución de Intendencia N° 034-005-0000971/SUNAT, de fecha 15/03/2016.<br>
      Representación impresa del {{ $tipo_documento_nombre ?? 'COMPROBANTE DE PAGO ELECTRÓNICO' }}<br>
      Para consultar el comprobante ingrese a www.sunat.gob.pe
      @if($hash)
        <br><b>Código Hash:</b> {{ $hash }}
      @endif
    </div>

  </div>
</body>
</html>