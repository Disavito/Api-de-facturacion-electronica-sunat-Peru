# Ejemplos de Notas de Débito - API SUNAT

Este documento proporciona ejemplos completos para implementar notas de débito basándose en los ejemplos oficiales de Greenter.

## Tabla de Contenidos

1. [Nota de Débito Básica](#nota-de-débito-básica)
2. [Nota de Débito por Intereses por Mora](#nota-de-débito-por-intereses-por-mora)
3. [Nota de Débito para Boleta](#nota-de-débito-para-boleta)
4. [Nota de Débito por Penalidades](#nota-de-débito-por-penalidades)
5. [Catálogo de Motivos](#catálogo-de-motivos)

## Nota de Débito Básica

Basado en `nota-debito.php` del ejemplo de Greenter.

### Request POST `/api/v1/debit-notes`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "serie": "FD01",
  "fecha_emision": "2025-09-06",
  "moneda": "PEN",
  "tipo_doc_afectado": "01",
  "num_doc_afectado": "F001-111",
  "cod_motivo": "02",
  "des_motivo": "AUMENTO EN EL VALOR",
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
  "detalles": [
    {
      "codigo": "C023",
      "descripcion": "AUMENTO POR CONCEPTO ADICIONAL",
      "unidad": "NIU",
      "cantidad": 2,
      "mto_valor_unitario": 50.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    },
    {
      "codigo": "C02",
      "descripcion": "AUMENTO POR RECARGO",
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

## Nota de Débito por Intereses por Mora

Para cobros de intereses por pago tardío.

### Request POST `/api/v1/debit-notes`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "serie": "FD01",
  "fecha_emision": "2025-09-06",
  "moneda": "PEN",
  "tipo_doc_afectado": "01",
  "num_doc_afectado": "F001-222",
  "cod_motivo": "01",
  "des_motivo": "INTERESES POR MORA",
  "client": {
    "tipo_documento": "6",
    "numero_documento": "20123456789",
    "razon_social": "EMPRESA DE PRUEBA SAC"
  },
  "detalles": [
    {
      "codigo": "INT001",
      "descripcion": "INTERESES POR PAGO TARDIO",
      "unidad": "NIU",
      "cantidad": 1,
      "mto_valor_unitario": 100.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    }
  ]
}
```

## Nota de Débito para Boleta

Nota de débito aplicada a una boleta de venta.

### Request POST `/api/v1/debit-notes`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "serie": "BD01",
  "fecha_emision": "2025-09-06",
  "moneda": "PEN",
  "tipo_doc_afectado": "03",
  "num_doc_afectado": "B001-333",
  "cod_motivo": "03",
  "des_motivo": "PENALIDADES/OTROS CONCEPTOS",
  "client": {
    "tipo_documento": "1",
    "numero_documento": "12345678",
    "razon_social": "CLIENTE NATURAL"
  },
  "detalles": [
    {
      "codigo": "PEN001",
      "descripcion": "PENALIDAD POR INCUMPLIMIENTO",
      "unidad": "NIU",
      "cantidad": 1,
      "mto_valor_unitario": 50.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    }
  ]
}
```

## Nota de Débito por Penalidades

Para aplicar penalidades o multas contractuales.

### Request POST `/api/v1/debit-notes`

```json
{
  "company_id": 1,
  "branch_id": 1,
  "serie": "FD01",
  "fecha_emision": "2025-09-06",
  "moneda": "PEN",
  "tipo_doc_afectado": "01",
  "num_doc_afectado": "F001-444",
  "cod_motivo": "03",
  "des_motivo": "PENALIDADES/OTROS CONCEPTOS",
  "client": {
    "tipo_documento": "6",
    "numero_documento": "20987654321",
    "razon_social": "EMPRESA CONTRATISTA SAC",
    "direccion": "AV. CONTRATISTAS 456",
    "ubigeo": "150101",
    "distrito": "LIMA",
    "provincia": "LIMA",
    "departamento": "LIMA"
  },
  "detalles": [
    {
      "codigo": "MULT01",
      "descripcion": "MULTA POR RETRASO EN ENTREGA",
      "unidad": "NIU",
      "cantidad": 1,
      "mto_valor_unitario": 500.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    },
    {
      "codigo": "MULT02",
      "descripcion": "PENALIDAD POR CALIDAD",
      "unidad": "NIU",
      "cantidad": 1,
      "mto_valor_unitario": 300.00,
      "porcentaje_igv": 18.00,
      "tip_afe_igv": "10"
    }
  ],
  "leyendas": [
    {
      "code": "1000",
      "value": "SON NOVECIENTOS CUARENTA Y CUATRO CON 00/100 SOLES"
    }
  ]
}
```

## Catálogo de Motivos

### Request GET `/api/v1/debit-notes/catalogs/motivos`

```json
{
  "success": true,
  "data": [
    {"code": "01", "name": "Intereses por mora"},
    {"code": "02", "name": "Aumento en el valor"},
    {"code": "03", "name": "Penalidades/otros conceptos"},
    {"code": "10", "name": "Ajustes de operaciones de exportación"},
    {"code": "11", "name": "Ajustes afectos al IVAP"}
  ],
  "message": "Motivos de nota de débito obtenidos correctamente"
}
```

## Operaciones Disponibles

### Crear Nota de Débito
```
POST /api/v1/debit-notes
```

### Listar Notas de Débito
```
GET /api/v1/debit-notes
GET /api/v1/debit-notes?company_id=1&estado_sunat=PENDIENTE
```

### Obtener Nota de Débito específica
```
GET /api/v1/debit-notes/{id}
```

### Enviar a SUNAT
```
POST /api/v1/debit-notes/{id}/send-sunat
```

### Generar PDF
```
POST /api/v1/debit-notes/{id}/generate-pdf
```

**Respuesta exitosa:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "serie": "FD01",
    "correlativo": "000001",
    "numero_documento": "FD01-000001",
    "fecha_emision": "2025-09-06",
    "pdf_path": "debit_notes/FD01-000001.pdf",
    "pdf_url": "http://localhost:8000/storage/debit_notes/FD01-000001.pdf",
    "download_url": "http://localhost:8000/api/v1/debit-notes/1/download-pdf",
    "estado_sunat": "ACEPTADO",
    "mto_imp_venta": 118.00,
    "moneda": "PEN",
    "client": {
      "numero_documento": "20123456789",
      "razon_social": "EMPRESA DE PRUEBA SAC"
    }
  },
  "message": "PDF de nota de débito generado correctamente"
}
```

### Descargar Archivos
```
GET /api/v1/debit-notes/{id}/download-xml
GET /api/v1/debit-notes/{id}/download-cdr  
GET /api/v1/debit-notes/{id}/download-pdf
```

### Catálogo de Motivos
```
GET /api/v1/debit-notes/catalogs/motivos
```

## Validaciones Importantes

1. **Motivos válidos**: Solo códigos 01, 02, 03, 10, 11
2. **Documentos afectados**: Solo 01 (Factura), 03 (Boleta)
3. **Detalles**: Al menos un detalle es requerido
4. **Montos**: Deben ser positivos (a diferencia de las notas de crédito)
5. **Tipo de documento**: Siempre es '08' para notas de débito

## Diferencias con Notas de Crédito

- **Propósito**: Las notas de débito AUMENTAN el monto a pagar
- **Motivos**: Diferentes códigos de catálogo (01-03, 10-11)
- **Forma de pago**: No requiere forma de pago (similar a notas de crédito al contado)
- **Montos**: Siempre positivos, representan cargos adicionales

## Notas Técnicas

- Los cálculos de totales se realizan automáticamente
- La leyenda se genera automáticamente si no se proporciona
- El correlativo se asigna automáticamente por sucursal
- Soporte completo para operaciones gravadas, exoneradas, inafectas
- Integración completa con Greenter para envío a SUNAT
- No requiere configuración de forma de pago (similar a documentos al contado)