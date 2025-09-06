# Ejemplos de Notas de Crédito - API SUNAT

Este documento proporciona ejemplos completos para implementar notas de crédito basándose en los ejemplos oficiales de Greenter.

## Tabla de Contenidos

1. [Nota de Crédito Básica](#nota-de-crédito-básica)
2. [Nota de Crédito con Forma de Pago a Crédito](#nota-de-crédito-con-forma-de-pago-a-crédito)
3. [Nota de Crédito para Boleta](#nota-de-crédito-para-boleta)
4. [Nota de Crédito con Guías](#nota-de-crédito-con-guías)
5. [Catálogo de Motivos](#catálogo-de-motivos)

## Nota de Crédito Básica

Basado en `nota-credito.php` del ejemplo de Greenter.

### Request POST `/api/v1/credit-notes`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "serie": "FF01",
  "fecha_emision": "2025-09-06",
  "moneda": "PEN",
  "tipo_doc_afectado": "01",
  "num_doc_afectado": "F001-111",
  "cod_motivo": "07",
  "des_motivo": "DEVOLUCION POR ITEM",
  "client": {
    "tipo_documento": "6",
    "numero_documento": "20123456789",
    "razon_social": "EMPRESA DE PRUEBA SAC",
    "direccion": "AV. EJEMPLO 123",
    "ubigeo": "150101",
    "distrito": "LIMA",
    "provincia": "LIMA",
    "departamento": "LIMA"
  },
  "guias": [
    {
      "tipo_doc": "09",
      "nro_doc": "0001-213"
    }
  ],
  "detalles": [
    {
      "codigo": "C023",
      "descripcion": "PROD 1",
      "unidad": "NIU",
      "cantidad": 2,
      "mto_valor_unitario": 50.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    },
    {
      "codigo": "C02",
      "descripcion": "PROD 2", 
      "unidad": "NIU",
      "cantidad": 2,
      "mto_valor_unitario": 50.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    }
  ],
  "leyendas": [
    {
      "code": "1000",
      "value": "SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES"
    }
  ]
}
```

## Nota de Crédito con Forma de Pago a Crédito

Basado en `nota-credito-forma-pago.php` del ejemplo de Greenter.

### Request POST `/api/v1/credit-notes`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "serie": "FF01", 
  "fecha_emision": "2025-09-06",
  "moneda": "PEN",
  "forma_pago_tipo": "Credito",
  "forma_pago_cuotas": [
    {
      "monto": 236.00,
      "fecha_pago": "2025-09-11"
    }
  ],
  "tipo_doc_afectado": "01",
  "num_doc_afectado": "F001-111", 
  "cod_motivo": "13",
  "des_motivo": "AJUSTES - MONTOS Y/O FECHAS DE PAGO",
  "client": {
    "tipo_documento": "6",
    "numero_documento": "20123456789",
    "razon_social": "EMPRESA DE PRUEBA SAC"
  },
  "guias": [
    {
      "tipo_doc": "09",
      "nro_doc": "0001-213"
    }
  ],
  "detalles": [
    {
      "codigo": "C023",
      "descripcion": "PROD 1",
      "unidad": "NIU", 
      "cantidad": 2,
      "mto_valor_unitario": 50.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    },
    {
      "codigo": "C02",
      "descripcion": "PROD 2",
      "unidad": "NIU",
      "cantidad": 2, 
      "mto_valor_unitario": 50.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    }
  ]
}
```

## Nota de Crédito para Boleta

Basado en `nota-credito-boleta.php` del ejemplo de Greenter.

### Request POST `/api/v1/credit-notes`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "serie": "BB01",
  "fecha_emision": "2025-09-06", 
  "moneda": "PEN",
  "tipo_doc_afectado": "03",
  "num_doc_afectado": "B001-12",
  "cod_motivo": "01", 
  "des_motivo": "ANULACION DE LA OPERACION",
  "client": {
    "tipo_documento": "1",
    "numero_documento": "12345678",
    "razon_social": "CLIENTE NATURAL"
  },
  "detalles": [
    {
      "codigo": "C023",
      "descripcion": "PROD 1",
      "unidad": "NIU",
      "cantidad": 2,
      "mto_valor_unitario": 50.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    },
    {
      "codigo": "C02", 
      "descripcion": "PROD 2",
      "unidad": "NIU",
      "cantidad": 2,
      "mto_valor_unitario": 50.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    }
  ]
}
```

## Nota de Crédito con Guías

Ejemplo con múltiples guías relacionadas.

### Request POST `/api/v1/credit-notes`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "serie": "FF01",
  "fecha_emision": "2025-09-06",
  "moneda": "PEN",
  "tipo_doc_afectado": "01", 
  "num_doc_afectado": "F001-000123",
  "cod_motivo": "06",
  "des_motivo": "DEVOLUCION TOTAL",
  "client": {
    "tipo_documento": "6",
    "numero_documento": "20123456789", 
    "razon_social": "EMPRESA DE PRUEBA SAC"
  },
  "guias": [
    {
      "tipo_doc": "09",
      "nro_doc": "G001-001"
    },
    {
      "tipo_doc": "09",
      "nro_doc": "G001-002" 
    }
  ],
  "detalles": [
    {
      "codigo": "PROD001",
      "descripcion": "PRODUCTO DEVUELTO",
      "unidad": "NIU",
      "cantidad": 1,
      "mto_valor_unitario": 100.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    }
  ]
}
```

## Catálogo de Motivos

### Request GET `/api/v1/credit-notes/catalogs/motivos`

```json
{
  "success": true,
  "data": [
    {"code": "01", "name": "Anulación de la operación"},
    {"code": "02", "name": "Anulación por error en el RUC"},
    {"code": "03", "name": "Corrección por error en la descripción"},
    {"code": "04", "name": "Descuento global"},
    {"code": "05", "name": "Descuento por ítem"},
    {"code": "06", "name": "Devolución total"},
    {"code": "07", "name": "Devolución por ítem"},
    {"code": "08", "name": "Bonificación"},
    {"code": "09", "name": "Disminución en el valor"},
    {"code": "10", "name": "Otros conceptos"},
    {"code": "11", "name": "Ajustes de operaciones de exportación"},
    {"code": "12", "name": "Ajustes afectos al IVAP"},
    {"code": "13", "name": "Ajustes - montos y/o fechas de pago"}
  ],
  "message": "Motivos de nota de crédito obtenidos correctamente"
}
```

## Operaciones Disponibles

### Crear Nota de Crédito
```
POST /api/v1/credit-notes
```

### Listar Notas de Crédito
```
GET /api/v1/credit-notes
GET /api/v1/credit-notes?company_id=1&estado_sunat=PENDIENTE
```

### Obtener Nota de Crédito específica
```
GET /api/v1/credit-notes/{id}
```

### Enviar a SUNAT
```
POST /api/v1/credit-notes/{id}/send-sunat
```

### Generar PDF
```
POST /api/v1/credit-notes/{id}/generate-pdf
```

### Descargar Archivos
```
GET /api/v1/credit-notes/{id}/download-xml
GET /api/v1/credit-notes/{id}/download-cdr  
GET /api/v1/credit-notes/{id}/download-pdf
```

### Catálogo de Motivos
```
GET /api/v1/credit-notes/catalogs/motivos
```

## Validaciones Importantes

1. **Motivos válidos**: Solo códigos del 01 al 13
2. **Documentos afectados**: Solo 01 (Factura), 03 (Boleta), 07 (Nota Crédito), 08 (Nota Débito)
3. **Forma de pago**: Si es "Credito", las cuotas son obligatorias
4. **Fecha de cuotas**: Debe ser posterior a la fecha de emisión
5. **Guías**: Tipo de documento y número son obligatorios si se especifican
6. **Detalles**: Al menos un detalle es requerido

## Notas Técnicas

- Los cálculos de totales se realizan automáticamente
- La leyenda se genera automáticamente si no se proporciona
- El correlativo se asigna automáticamente por sucursal
- Soporte completo para operaciones gravadas, exoneradas, inafectas y gratuitas
- Integración completa con Greenter para envío a SUNAT