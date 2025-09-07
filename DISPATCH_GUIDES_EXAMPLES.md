# Ejemplos de Guías de Remisión - API SUNAT

Este documento proporciona ejemplos completos para implementar guías de remisión electrónicas basándose en los ejemplos oficiales de Greenter y las especificaciones de SUNAT.

## Tabla de Contenidos

1. [Guía de Remisión con Transporte Privado](#guía-de-remisión-con-transporte-privado)
2. [Guía de Remisión con Transporte Público](#guía-de-remisión-con-transporte-público)
3. [Traslado entre Establecimientos](#traslado-entre-establecimientos)
4. [Guía con Vehículos Secundarios](#guía-con-vehículos-secundarios)
5. [Catálogos de Referencias](#catálogos-de-referencias)
6. [Estados y Flujo de Procesamiento](#estados-y-flujo-de-procesamiento)

## Guía de Remisión con Transporte Privado

### Request POST `/api/v1/dispatch-guides`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "client_id": 1,
  "serie": "T001",
  "fecha_emision": "2025-09-06",
  "fecha_traslado": "2025-09-07",
  "version": "2022",
  
  "cod_traslado": "01",
  "des_traslado": "Venta",
  "mod_traslado": "02",
  "peso_total": 45.500,
  "und_peso_total": "KGM",
  "num_bultos": 3,
  
  "partida": {
    "ubigeo": "150101",
    "direccion": "AV LIMA 123, CERCADO DE LIMA"
  },
  "llegada": {
    "ubigeo": "150203", 
    "direccion": "AV ARRIOLA 456, SAN MARTIN DE PORRES"
  },
  
  "transportista": null,
  "vehiculo": {
    "placa_principal": "ABC123",
    "placa_secundaria": null,
    "conductor": {
      "tipo": "Principal",
      "tipo_doc": "1",
      "num_doc": "12345678",
      "licencia": "A12345678",
      "nombres": "CARLOS ALBERTO",
      "apellidos": "RODRIGUEZ TORRES"
    }
  },
  
  "detalles": [
    {
      "cantidad": 10,
      "unidad": "NIU",
      "descripcion": "PRODUCTO ELECTRÓNICO PORTÁTIL",
      "codigo": "PROD001",
      "peso_total": 25.250
    },
    {
      "cantidad": 5,
      "unidad": "NIU",
      "descripcion": "ACCESORIO TECNOLÓGICO",
      "codigo": "PROD002", 
      "peso_total": 20.250
    }
  ],
  
  "usuario_creacion": "ADMIN_USER"
}
```

## Guía de Remisión con Transporte Público

### Request POST `/api/v1/dispatch-guides`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "client_id": 2,
  "serie": "T001",
  "fecha_emision": "2025-09-06",
  "fecha_traslado": "2025-09-07",
  
  "cod_traslado": "02",
  "des_traslado": "Compra",
  "mod_traslado": "01",
  "peso_total": 150.750,
  "und_peso_total": "KGM",
  "num_bultos": 10,
  
  "partida": {
    "ubigeo": "150101",
    "direccion": "ALMACEN PROVEEDOR, AV INDUSTRIAL 789"
  },
  "llegada": {
    "ubigeo": "150203",
    "direccion": "ALMACEN PRINCIPAL, AV COMERCIAL 123"
  },
  
  "transportista": {
    "tipo_doc": "6",
    "num_doc": "20123456789", 
    "razon_social": "TRANSPORTES PROFESIONALES SAC",
    "nro_mtc": "MTC001234"
  },
  "vehiculo": {
    "placa_principal": "TPU456",
    "placa_secundaria": null
  },
  
  "detalles": [
    {
      "cantidad": 100,
      "unidad": "NIU",
      "descripcion": "MATERIA PRIMA INDUSTRIAL",
      "codigo": "MP001",
      "peso_total": 150.750
    }
  ]
}
```

## Traslado entre Establecimientos

Para traslados entre establecimientos de la misma empresa.

### Request POST `/api/v1/dispatch-guides`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "client_id": 1,
  "serie": "T001", 
  "fecha_emision": "2025-09-06",
  "fecha_traslado": "2025-09-07",
  
  "cod_traslado": "04",
  "des_traslado": "Traslado entre establecimientos de la misma empresa",
  "mod_traslado": "02",
  "peso_total": 85.000,
  "und_peso_total": "KGM",
  "num_bultos": 5,
  
  "partida": {
    "ubigeo": "150101",
    "direccion": "ALMACEN CENTRAL - AV LIMA 100"
  },
  "llegada": {
    "ubigeo": "150203",
    "direccion": "SUCURSAL NORTE - AV INDUSTRIAL 200"
  },
  
  "vehiculo": {
    "placa_principal": "EMP789",
    "conductor": {
      "tipo": "Principal",
      "tipo_doc": "1", 
      "num_doc": "87654321",
      "licencia": "B87654321",
      "nombres": "MIGUEL ANGEL",
      "apellidos": "SANCHEZ TORRES"
    }
  },
  
  "detalles": [
    {
      "cantidad": 50,
      "unidad": "NIU",
      "descripcion": "INVENTARIO PARA SUCURSAL",
      "codigo": "INV001",
      "peso_total": 85.000
    }
  ]
}
```

## Guía con Vehículos Secundarios

Para transportes que requieren múltiples vehículos.

### Request POST `/api/v1/dispatch-guides`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "client_id": 3,
  "serie": "T001",
  "fecha_emision": "2025-09-06",
  "fecha_traslado": "2025-09-07",
  
  "cod_traslado": "01",
  "des_traslado": "Venta",
  "mod_traslado": "02",
  "peso_total": 250.500,
  "und_peso_total": "KGM",
  "num_bultos": 20,
  
  "partida": {
    "ubigeo": "150101",
    "direccion": "PLANTA DE PRODUCCIÓN"
  },
  "llegada": {
    "ubigeo": "150203", 
    "direccion": "CENTRO DE DISTRIBUCIÓN"
  },
  
  "vehiculo": {
    "placa_principal": "VEH001",
    "placa_secundaria": ["VEH002", "VEH003"],
    "conductor": {
      "tipo": "Principal",
      "tipo_doc": "1",
      "num_doc": "11111111",
      "licencia": "A11111111", 
      "nombres": "PEDRO LUIS",
      "apellidos": "MARTINEZ SILVA"
    }
  },
  
  "detalles": [
    {
      "cantidad": 200,
      "unidad": "NIU",
      "descripcion": "CARGA INDUSTRIAL PESADA",
      "codigo": "HEAVY001",
      "peso_total": 250.500
    }
  ]
}
```

## Operaciones Disponibles

### Crear Guía de Remisión
```
POST /api/v1/dispatch-guides
```

### Listar Guías de Remisión
```
GET /api/v1/dispatch-guides
GET /api/v1/dispatch-guides?company_id=1&estado_sunat=PENDIENTE
GET /api/v1/dispatch-guides?mod_traslado=02&cod_traslado=01
```

### Obtener Guía específica
```
GET /api/v1/dispatch-guides/{id}
```

### Enviar a SUNAT
```
POST /api/v1/dispatch-guides/{id}/send-sunat
```

**Respuesta:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "estado_sunat": "PROCESANDO"
  },
  "ticket": "ABC123XYZ456",
  "message": "Guía de remisión enviada correctamente a SUNAT"
}
```

### Consultar Estado en SUNAT
```
POST /api/v1/dispatch-guides/{id}/check-status
```

**Respuesta:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "estado_sunat": "ACEPTADO",
    "respuesta_sunat": "Guía procesada correctamente"
  },
  "message": "Estado de la guía consultado correctamente"
}
```

### Generar PDF
```
POST /api/v1/dispatch-guides/{id}/generate-pdf
```

**Respuesta exitosa:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "serie": "T001",
    "correlativo": "000001",
    "numero_documento": "T001-000001",
    "fecha_emision": "2025-09-06",
    "fecha_traslado": "2025-09-07",
    "pdf_path": "dispatch_guides/T001-000001.pdf",
    "pdf_url": "http://localhost:8000/storage/dispatch_guides/T001-000001.pdf",
    "download_url": "http://localhost:8000/api/v1/dispatch-guides/1/download-pdf",
    "estado_sunat": "ACEPTADO",
    "peso_total": 45.500,
    "modalidad_traslado": "Transporte privado",
    "motivo_traslado": "Venta",
    "destinatario": {
      "numero_documento": "20123456789",
      "razon_social": "EMPRESA DESTINATARIO SAC"
    }
  },
  "message": "PDF de guía de remisión generado correctamente"
}
```

### Descargar Archivos
```
GET /api/v1/dispatch-guides/{id}/download-xml
GET /api/v1/dispatch-guides/{id}/download-cdr  
GET /api/v1/dispatch-guides/{id}/download-pdf
```

## Catálogos de Referencias

### Motivos de Traslado
```
GET /api/v1/dispatch-guides/catalogs/transfer-reasons
```

```json
{
  "success": true,
  "data": [
    {"code": "01", "name": "Venta"},
    {"code": "02", "name": "Compra"},
    {"code": "03", "name": "Venta con entrega a terceros"},
    {"code": "04", "name": "Traslado entre establecimientos de la misma empresa"},
    {"code": "05", "name": "Consignación"},
    {"code": "06", "name": "Devolución"},
    {"code": "07", "name": "Recojo de bienes transformados"},
    {"code": "08", "name": "Importación"},
    {"code": "09", "name": "Exportación"},
    {"code": "13", "name": "Otros"},
    {"code": "14", "name": "Venta sujeta a confirmación del comprador"},
    {"code": "18", "name": "Traslado de bienes para transformación"},
    {"code": "19", "name": "Traslado de bienes desde un centro de acopio"}
  ],
  "message": "Motivos de traslado obtenidos correctamente"
}
```

### Modalidades de Transporte
```
GET /api/v1/dispatch-guides/catalogs/transport-modes
```

```json
{
  "success": true,
  "data": [
    {"code": "01", "name": "Transporte público"},
    {"code": "02", "name": "Transporte privado"}
  ],
  "message": "Modalidades de transporte obtenidas correctamente"
}
```

## Estados y Flujo de Procesamiento

### Estados SUNAT:
- **PENDIENTE**: Guía creada, no enviada a SUNAT
- **PROCESANDO**: Enviada a SUNAT, esperando respuesta
- **ACEPTADO**: Procesada y aceptada por SUNAT
- **RECHAZADO**: Rechazada por SUNAT con observaciones

### Flujo de Procesamiento:
1. **Crear guía** → Estado: PENDIENTE
2. **Enviar a SUNAT** → Estado: PROCESANDO + Ticket
3. **Consultar estado** → Estado: ACEPTADO/RECHAZADO + CDR
4. **Generar PDF** → Documento listo para impresión

## Validaciones Importantes

### Campos Obligatorios Generales:
- `company_id`, `branch_id`, `client_id`
- `serie`, `fecha_emision`, `fecha_traslado`
- `cod_traslado`, `mod_traslado`
- `peso_total`, `und_peso_total`
- `partida`, `llegada` (con ubigeo y dirección)
- `detalles` (al menos un item)
- `vehiculo` (con placa principal)

### Validaciones por Modalidad:

#### Transporte Público (`mod_traslado = "01"`):
- **Requerido**: `transportista` con tipo_doc, num_doc, razon_social, nro_mtc
- **Opcional**: datos de conductor (los maneja la empresa transportista)

#### Transporte Privado (`mod_traslado = "02"`):
- **Requerido**: `vehiculo.conductor` con todos los datos del conductor
- **Opcional**: transportista (no aplica)

### Reglas de Negocio:
1. **Fechas**: `fecha_traslado` debe ser igual o posterior a `fecha_emision`
2. **Peso**: Suma de `peso_total` de detalles debe coincidir con `peso_total` general
3. **Ubigeos**: Deben ser códigos válidos de 6 dígitos del INEI
4. **Correlativo**: Se genera automáticamente por serie y sucursal
5. **Estados**: Solo guías PENDIENTES pueden enviarse a SUNAT
6. **Ticket**: Solo guías PROCESANDO pueden consultar estado

## Diferencias con Otros Documentos

### Características Únicas:
- **Procesamiento asíncrono** con tickets (como resúmenes diarios)
- **Datos de transporte obligatorios** (vehículos, conductores, transportistas)
- **Direcciones con ubigeo** para origen y destino
- **Peso y bultos** como datos físicos del traslado
- **Modalidades específicas** que cambian campos requeridos
- **Versión 2022** es la vigente para SUNAT

## Notas Técnicas

- Integración completa con Greenter para procesamiento SUNAT
- Soporte para correlativo automático por serie y sucursal
- Validación cruzada de modalidades de transporte
- Manejo de vehículos secundarios para cargas pesadas
- Soporte completo para diferentes motivos de traslado
- Sistema de estados para tracking del flujo SUNAT
- No requiere cálculos de impuestos (solo datos de transporte)