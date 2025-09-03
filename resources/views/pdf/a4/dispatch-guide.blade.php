<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Guía de Remisión Electrónica</title>
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

    /* ================= INFO TRASLADO ================= */
    .info-traslado {
      margin-top: 15px;
      margin-bottom: 15px;
      padding: 10px;
      border: 2px solid #4caf50;
      border-radius: 8px;
      background-color: #f1f8e9;
    }

    .info-traslado h3 {
      margin: 0 0 10px 0;
      color: #4caf50;
      font-size: 13px;
      text-align: center;
    }

    .info-traslado .info {
      display: table;
      width: 100%;
    }

    .info-traslado .info-row {
      display: table-row;
    }

    .info-traslado .info-label {
      display: table-cell;
      width: 150px;
      padding: 3px;
      font-weight: bold;
      font-size: 10px;
    }

    .info-traslado .info-value {
      display: table-cell;
      padding: 3px;
      font-size: 10px;
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
      height: 200px;
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
          <p><b>GUÍA DE REMISIÓN ELECTRÓNICA</b></p>
          <p><b>{{ $document->numero_completo ?? 'T001-00000001' }}</b></p>
        </div>
      </div>
    </div>

    <!-- INFORMACIÓN DEL TRASLADO -->
    <div class="info-traslado">
      <h3>INFORMACIÓN DEL TRASLADO</h3>
      <div class="info">
        <div class="info-row">
          <div class="info-label">FECHA EMISIÓN:</div>
          <div class="info-value">{{ $fecha_emision ?? date('d/m/Y') }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">FECHA TRASLADO:</div>
          <div class="info-value">{{ $fecha_traslado ?? date('d/m/Y') }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">MOTIVO TRASLADO:</div>
          <div class="info-value">{{ $motivo_traslado ?? 'VENTA' }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">MODALIDAD:</div>
          <div class="info-value">{{ $modalidad_traslado ?? 'TRANSPORTE PÚBLICO' }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">PESO TOTAL:</div>
          <div class="info-value">{{ $peso_total_formatted ?? '0.000 KGM' }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">N° BULTOS:</div>
          <div class="info-value">{{ $document->num_bultos ?? '1' }}</div>
        </div>
      </div>
    </div>

    <!-- DATOS DEL DESTINATARIO -->
    <div class="datos">
      <div>
        <p>
          <b>DESTINATARIO:</b> {{ $destinatario->razon_social ?? 'DESTINATARIO' }}<br>
          <b>{{ ($destinatario->tipo_documento ?? '1') == '6' ? 'RUC' : 'DNI' }}:</b> {{ $destinatario->numero_documento ?? '' }}<br>
          @if(!empty($destinatario->direccion ?? ''))
          <b>DIRECCIÓN:</b> {{ $destinatario->direccion }}
          @endif
        </p>
      </div>
      <div>
        <p>
          <b>PUNTO PARTIDA:</b> {{ $document->partida_direccion ?? 'Dirección de partida' }}<br>
          <b>PUNTO LLEGADA:</b> {{ $document->llegada_direccion ?? 'Dirección de llegada' }}
        </p>
      </div>
    </div>

    @if($document->mod_traslado ?? '01' == '01')
    <!-- DATOS DEL TRANSPORTISTA -->
    <div class="datos">
      <div>
        <p>
          <b>TRANSPORTISTA:</b> {{ $document->transportista_razon_social ?? 'TRANSPORTISTA' }}<br>
          <b>RUC:</b> {{ $document->transportista_num_doc ?? '' }}<br>
          @if($document->transportista_nro_mtc ?? null)
          <b>N° MTC:</b> {{ $document->transportista_nro_mtc }}
          @endif
        </p>
      </div>
      <div>
        <p>
          <b>VEHÍCULO PRINCIPAL:</b> {{ $document->vehiculo_placa ?? 'ABC-123' }}<br>
          @if($document->vehiculos_secundarios ?? null)
          @php $vehiculosSecundarios = is_array($document->vehiculos_secundarios) ? $document->vehiculos_secundarios : json_decode($document->vehiculos_secundarios, true) @endphp
          @if($vehiculosSecundarios)
            @foreach($vehiculosSecundarios as $index => $vehiculo)
            <b>VEHÍCULO {{ $index + 2 }}:</b> {{ $vehiculo['placa'] }}<br>
            @endforeach
          @endif
          @endif
        </p>
      </div>
    </div>
    @endif

    @if($document->mod_traslado ?? '02' == '02')
    <!-- DATOS DEL CONDUCTOR -->
    <div class="datos">
      <div>
        <p>
          <b>CONDUCTOR:</b> {{ $document->conductor_nombres ?? 'CONDUCTOR' }} {{ $document->conductor_apellidos ?? '' }}<br>
          <b>DNI:</b> {{ $document->conductor_num_doc ?? '' }}<br>
          <b>LICENCIA:</b> {{ $document->conductor_licencia ?? '' }}
        </p>
      </div>
      <div>
        <p>
          <b>VEHÍCULO:</b> {{ $document->vehiculo_placa ?? 'ABC-123' }}
        </p>
      </div>
    </div>
    @endif

    <!-- TABLA DE ITEMS -->
    <table>
      <thead>
        <tr>
          <th>Nº</th>
          <th>CÓDIGO</th>
          <th>DESCRIPCIÓN</th>
          <th>UNIDAD</th>
          <th>CANT.</th>
          <th>PESO</th>
        </tr>
      </thead>
      <tbody>
        @if(is_array($detalles ?? []) && count($detalles) > 0)
                    @foreach($detalles as $index => $detalle)
        <tr>
          <td>{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
          <td>{{ $detalle['codigo_interno'] ?? $detalle['codigo'] ?? '' }}</td>
          <td>{{ $detalle['descripcion'] ?? 'PRODUCTO' }}</td>
          <td>{{ $detalle['unidad'] ?? 'NIU' }}</td>
          <td>{{ number_format($detalle['cantidad'] ?? 0, 2) }}</td>
          <td>{{ number_format($detalle['peso_total'] ?? 0, 3) }} KGM</td>
        </tr>
            @endforeach
        @endif
        
        <!-- Fila espaciadora dinámica -->
        <tr class="fila-espaciadora">
          <td colspan="6">&nbsp;</td>
        </tr>
      </tbody>
    </table>

    @if($document->observaciones ?? null)
    <!-- OBSERVACIONES -->
    <div style="margin-top: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
      <strong>OBSERVACIONES:</strong><br>
      {{ $document->observaciones }}
    </div>
    @endif

    <!-- CONTENIDO EXTRA AL FINAL -->
    <div class="footer-extra">
      <div style="text-align: center; font-size: 10px;">
        <strong>INFORMACIÓN ADICIONAL:</strong><br>
        • Esta guía de remisión se encuentra almacenada electrónicamente en SUNAT.<br>
        • Para verificar su autenticidad ingrese a www.sunat.gob.pe<br><br>
        
        @if($document->codigo_hash ?? null)
        <strong>CÓDIGO HASH:</strong> {{ $document->codigo_hash }}<br><br>
        @endif
        
        Autorizado mediante resolución N° 034-005-0010431/SUNAT<br>
        Representación impresa de la {{ $tipo_documento_nombre ?? 'GUÍA DE REMISIÓN ELECTRÓNICA' }}<br>
        Para consultar el comprobante visite {{ $company->website }}<br>
        {{ $document->codigo_hash }}
      </div>
    </div>

  </div>
</body>
</html>