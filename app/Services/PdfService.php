<?php

namespace App\Services;


use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    // Formatos disponibles
    const FORMATS = [
        'A4' => ['width' => 210, 'height' => 297, 'unit' => 'mm'],
        'A5' => ['width' => 148, 'height' => 210, 'unit' => 'mm'],
        '80mm' => ['width' => 80, 'height' => 200, 'unit' => 'mm'], // Ticket común
        '50mm' => ['width' => 50, 'height' => 150, 'unit' => 'mm'], // Ticket pequeño
    ];

    public function generateInvoicePdf($invoice, string $format = 'A4'): string
    {
        $data = $this->prepareInvoiceData($invoice);
        $data['format'] = $format;
        
        $template = $this->getTemplate('invoice', $format);
        $html = View::make($template, $data)->render();
        
        $pdf = $this->createPdfInstance($html, $format);
        
        return $pdf->output();
    }

    public function generateBoletaPdf($boleta, string $format = 'A4'): string
    {
        $data = $this->prepareBoletaData($boleta);
        $data['format'] = $format;
        
        $template = $this->getTemplate('boleta', $format);
        $html = View::make($template, $data)->render();
        
        $pdf = $this->createPdfInstance($html, $format);
        
        return $pdf->output();
    }

    public function generateCreditNotePdf($creditNote, string $format = 'A4'): string
    {
        $data = $this->prepareCreditNoteData($creditNote);
        $data['format'] = $format;
        
        $template = $this->getTemplate('credit-note', $format);
        $html = View::make($template, $data)->render();
        
        $pdf = $this->createPdfInstance($html, $format);
        
        return $pdf->output();
    }

    public function generateDebitNotePdf($debitNote, string $format = 'A4'): string
    {
        $data = $this->prepareDebitNoteData($debitNote);
        $data['format'] = $format;
        
        $template = $this->getTemplate('debit-note', $format);
        $html = View::make($template, $data)->render();
        
        $pdf = $this->createPdfInstance($html, $format);
        
        return $pdf->output();
    }

    public function generateDispatchGuidePdf($dispatchGuide, string $format = 'A4'): string
    {
        $data = $this->prepareDispatchGuideData($dispatchGuide);
        $data['format'] = $format;
        
        $template = $this->getTemplate('dispatch-guide', $format);
        $html = View::make($template, $data)->render();
        
        $pdf = $this->createPdfInstance($html, $format);
        
        return $pdf->output();
    }

    public function generateDailySummaryPdf($dailySummary, string $format = 'A4'): string
    {
        $data = $this->prepareDailySummaryData($dailySummary);
        $data['format'] = $format;
        
        $template = $this->getTemplate('daily-summary', $format);
        $html = View::make($template, $data)->render();
        
        $pdf = $this->createPdfInstance($html, $format);
        
        return $pdf->output();
    }

    protected function prepareInvoiceData($invoice): array
    {
        // Preparar datos del cliente con valores por defecto
        $clientData = $invoice->client_data ?? json_decode($invoice->client_json, true) ?? [];
        if (!is_array($clientData)) {
            $clientData = [];
        }
        
        // Valores por defecto para cliente
        $client = array_merge([
            'razon_social' => 'CLIENTE',
            'tipo_documento' => '1',
            'numero_documento' => 'N/A',
            'direccion' => '',
            'ubigeo' => '',
            'distrito' => '',
            'provincia' => '',
            'departamento' => '',
        ], $clientData);

        // Preparar detalles con valores por defecto
        $detalles = $invoice->detalles ?? json_decode($invoice->detalles_json, true) ?? [];
        if (!is_array($detalles)) {
            $detalles = [];
        }

        return [
            'document' => $invoice,
            'company' => $invoice->company,
            'branch' => $invoice->branch,
            'client' => $client,
            'detalles' => $detalles,
            'totales' => $this->calculateInvoiceTotals($invoice),
            'fecha_emision' => $invoice->fecha_emision ? $invoice->fecha_emision->format('d/m/Y') : date('d/m/Y'),
            'fecha_vencimiento' => $invoice->fecha_vencimiento ? $invoice->fecha_vencimiento->format('d/m/Y') : null,
            'tipo_documento_nombre' => 'FACTURA ELECTRÓNICA',
        ];
    }

    protected function prepareBoletaData($boleta): array
    {
        return [
            'document' => $boleta,
            'company' => $boleta->company,
            'branch' => $boleta->branch,
            'client' => $boleta->client_data ?? json_decode($boleta->client_json, true),
            'detalles' => $boleta->detalles ?? json_decode($boleta->detalles_json, true),
            'totales' => $this->calculateBoletaTotals($boleta),
            'fecha_emision' => $boleta->fecha_emision->format('d/m/Y'),
            'tipo_documento_nombre' => 'BOLETA DE VENTA ELECTRÓNICA',
        ];
    }

    protected function prepareCreditNoteData($creditNote): array
    {
        return [
            'document' => $creditNote,
            'company' => $creditNote->company,
            'branch' => $creditNote->branch,
            'client' => $creditNote->client_data ?? json_decode($creditNote->client_json, true),
            'detalles' => $creditNote->detalles ?? json_decode($creditNote->detalles_json, true),
            'totales' => $this->calculateCreditNoteTotals($creditNote),
            'fecha_emision' => $creditNote->fecha_emision->format('d/m/Y'),
            'tipo_documento_nombre' => 'NOTA DE CRÉDITO ELECTRÓNICA',
            'documento_afectado' => [
                'tipo' => $this->getTipoDocumentoName($creditNote->tipo_doc_afectado),
                'numero' => $creditNote->num_doc_afectado,
            ],
            'motivo' => [
                'codigo' => $creditNote->cod_motivo,
                'descripcion' => $creditNote->des_motivo,
            ],
        ];
    }

    protected function prepareDebitNoteData($debitNote): array
    {
        return [
            'document' => $debitNote,
            'company' => $debitNote->company,
            'branch' => $debitNote->branch,
            'client' => $debitNote->client_data ?? json_decode($debitNote->client_json, true),
            'detalles' => $debitNote->detalles ?? json_decode($debitNote->detalles_json, true),
            'totales' => $this->calculateDebitNoteTotals($debitNote),
            'fecha_emision' => $debitNote->fecha_emision->format('d/m/Y'),
            'tipo_documento_nombre' => 'NOTA DE DÉBITO ELECTRÓNICA',
            'documento_afectado' => [
                'tipo' => $this->getTipoDocumentoName($debitNote->tipo_doc_afectado),
                'numero' => $debitNote->num_doc_afectado,
            ],
            'motivo' => [
                'codigo' => $debitNote->cod_motivo,
                'descripcion' => $debitNote->des_motivo,
            ],
        ];
    }

    protected function prepareDispatchGuideData($dispatchGuide): array
    {
        return [
            'document' => $dispatchGuide,
            'company' => $dispatchGuide->company,
            'branch' => $dispatchGuide->branch,
            'destinatario' => $dispatchGuide->destinatario,
            'detalles' => $dispatchGuide->detalles ?? json_decode($dispatchGuide->detalles_json, true),
            'fecha_emision' => $dispatchGuide->fecha_emision->format('d/m/Y'),
            'fecha_traslado' => $dispatchGuide->fec_traslado->format('d/m/Y'),
            'tipo_documento_nombre' => 'GUÍA DE REMISIÓN ELECTRÓNICA',
            'motivo_traslado' => $dispatchGuide->getMotivoTrasladoNameAttribute(),
            'modalidad_traslado' => $dispatchGuide->getModalidadTrasladoNameAttribute(),
            'peso_total_formatted' => number_format($dispatchGuide->peso_total, 3) . ' ' . $dispatchGuide->und_peso_total,
        ];
    }

    protected function calculateInvoiceTotals($invoice): array
    {
        $detalles = $invoice->detalles ?? json_decode($invoice->detalles_json, true) ?? [];
        if (!is_array($detalles)) {
            $detalles = [];
        }
        
        $subtotal = 0;
        $igv = 0;
        $total = 0;

        if (count($detalles) > 0) {
            foreach ($detalles as $detalle) {
                if (!is_array($detalle)) continue;
                
                $cantidad = $detalle['cantidad'] ?? 0;
                $valorUnitario = $detalle['mto_valor_unitario'] ?? 0;
                $valorVenta = $detalle['mto_valor_venta'] ?? ($cantidad * $valorUnitario);
                $igvDetalle = $detalle['igv'] ?? 0;
                
                $subtotal += $valorVenta;
                $igv += $igvDetalle;
            }
        }

        $total = $subtotal + $igv;

        return [
            'subtotal' => $subtotal,
            'igv' => $igv,
            'total' => $total,
            'subtotal_formatted' => number_format($subtotal, 2),
            'igv_formatted' => number_format($igv, 2),
            'total_formatted' => number_format($total, 2),
            'moneda' => $invoice->moneda ?? 'PEN',
            'moneda_nombre' => $this->getMonedaNombre($invoice->moneda ?? 'PEN'),
        ];
    }

    protected function calculateBoletaTotals($boleta): array
    {
        return $this->calculateInvoiceTotals($boleta); // Same calculation logic
    }

    protected function calculateCreditNoteTotals($creditNote): array
    {
        return $this->calculateInvoiceTotals($creditNote); // Same calculation logic
    }

    protected function calculateDebitNoteTotals($debitNote): array
    {
        return $this->calculateInvoiceTotals($debitNote); // Same calculation logic
    }

    protected function getTipoDocumentoName($codigo): string
    {
        return match($codigo) {
            '01' => 'FACTURA',
            '03' => 'BOLETA DE VENTA',
            '07' => 'NOTA DE CRÉDITO',
            '08' => 'NOTA DE DÉBITO',
            '09' => 'GUÍA DE REMISIÓN',
            default => 'DOCUMENTO'
        };
    }

    protected function getMonedaNombre($codigo): string
    {
        return match($codigo) {
            'PEN' => 'SOLES',
            'USD' => 'DÓLARES AMERICANOS',
            'EUR' => 'EUROS',
            default => 'SOLES'
        };
    }

    public function numeroALetras($numero): string
    {
        $unidades = [
            '', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve',
            'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 
            'dieciocho', 'diecinueve', 'veinte'
        ];

        $decenas = [
            '', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'
        ];

        $centenas = [
            '', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos',
            'seiscientos', 'setecientos', 'ochocientos', 'novecientos'
        ];

        // Convertir número a entero y obtener decimales
        $partes = explode('.', number_format($numero, 2, '.', ''));
        $entero = (int)$partes[0];
        $decimales = $partes[1];

        if ($entero == 0) {
            return "cero con $decimales/100";
        }

        $resultado = $this->convertirEntero($entero, $unidades, $decenas, $centenas);
        
        return trim($resultado) . " con $decimales/100";
    }

    protected function convertirEntero($numero, $unidades, $decenas, $centenas): string
    {
        if ($numero < 21) {
            return $unidades[$numero];
        }

        if ($numero < 100) {
            $dec = (int)($numero / 10);
            $uni = $numero % 10;
            
            if ($uni == 0) {
                return $decenas[$dec];
            } else {
                return $decenas[$dec] . ' y ' . $unidades[$uni];
            }
        }

        if ($numero < 1000) {
            $cen = (int)($numero / 100);
            $resto = $numero % 100;
            
            $resultado = ($numero == 100) ? 'cien' : $centenas[$cen];
            
            if ($resto > 0) {
                $resultado .= ' ' . $this->convertirEntero($resto, $unidades, $decenas, $centenas);
            }
            
            return $resultado;
        }

        // Para miles, millones, etc.
        if ($numero < 1000000) {
            $miles = (int)($numero / 1000);
            $resto = $numero % 1000;
            
            if ($miles == 1) {
                $resultado = 'mil';
            } else {
                $resultado = $this->convertirEntero($miles, $unidades, $decenas, $centenas) . ' mil';
            }
            
            if ($resto > 0) {
                $resultado .= ' ' . $this->convertirEntero($resto, $unidades, $decenas, $centenas);
            }
            
            return $resultado;
        }

        return 'número muy grande';
    }

    /**
     * Crea una instancia de DomPDF con el HTML y formato especificado
     */
    protected function createPdfInstance(string $html, string $format): Dompdf
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $pdf = new Dompdf($options);
        $pdf->loadHtml($html);
        
        $this->setPaperFormat($pdf, $format);
        $pdf->render();
        
        return $pdf;
    }

    /**
     * Configura el formato del papel según el tipo especificado
     */
    protected function setPaperFormat(Dompdf $pdf, string $format): void
    {
        if (!isset(self::FORMATS[$format])) {
            $format = 'A4'; // Fallback a A4
        }

        $formatConfig = self::FORMATS[$format];
        
        if ($format === 'A4' || $format === 'A5') {
            $pdf->setPaper($format, 'portrait');
        } else {
            // Para formatos personalizados (80mm, 50mm)
            $width = $this->mmToPt($formatConfig['width']);
            $height = $this->mmToPt($formatConfig['height']);
            $pdf->setPaper(array(0, 0, $width, $height), 'portrait');
        }
    }

    /**
     * Convierte milímetros a puntos (pts) para DomPDF
     */
    protected function mmToPt(float $mm): float
    {
        return $mm * 2.834645669; // 1mm = 2.834645669 pts
    }

    /**
     * Obtiene el template correcto según el tipo de documento y formato
     */
    protected function getTemplate(string $documentType, string $format): string
    {
        // Nueva estructura organizada por formato
        $formatTemplate = "pdf.{$format}.{$documentType}";
        
        // Verificar si existe el template específico para el formato
        if (View::exists($formatTemplate)) {
            return $formatTemplate;
        }
        
        // Fallback: intentar con el template A4 como predeterminado
        $a4Template = "pdf.a4.{$documentType}";
        if (View::exists($a4Template)) {
            return $a4Template;
        }
        
        // Último fallback: template en la raíz (estructura antigua)
        $rootTemplate = "pdf.{$documentType}";
        if (View::exists($rootTemplate)) {
            return $rootTemplate;
        }
        
        // Si no existe ninguno, usar A4 invoice como fallback absoluto
        return "pdf.a4.invoice";
    }

    /**
     * Obtiene los formatos disponibles
     */
    public function getAvailableFormats(): array
    {
        return array_keys(self::FORMATS);
    }

    /**
     * Valida si un formato es válido
     */
    public function isValidFormat(string $format): bool
    {
        return isset(self::FORMATS[$format]);
    }

    /**
     * Prepara datos para Daily Summary
     */
    protected function prepareDailySummaryData($dailySummary): array
    {
        return [
            'document' => $dailySummary,
            'company' => $dailySummary->company,
            'branch' => $dailySummary->branch,
            'detalles' => $dailySummary->detalles ?? json_decode($dailySummary->detalles_json, true),
            'fecha_emision' => $dailySummary->fecha_emision->format('d/m/Y'),
            'fecha_referencia' => $dailySummary->fec_resumen->format('d/m/Y'),
            'tipo_documento_nombre' => 'RESUMEN DIARIO DE BOLETAS',
            'totales' => $this->calculateDailySummaryTotals($dailySummary),
        ];
    }

    /**
     * Calcula totales para Daily Summary
     */
    protected function calculateDailySummaryTotals($dailySummary): array
    {
        $detalles = $dailySummary->detalles ?? json_decode($dailySummary->detalles_json, true);
        
        $totalGravada = 0;
        $totalIgv = 0;
        $totalVenta = 0;

        if ($detalles) {
            foreach ($detalles as $detalle) {
                $totalGravada += $detalle['mto_oper_gravadas'] ?? 0;
                $totalIgv += $detalle['mto_igv'] ?? 0;
                $totalVenta += $detalle['mto_imp_venta'] ?? 0;
            }
        }

        return [
            'total_gravada' => $totalGravada,
            'total_igv' => $totalIgv,
            'total_venta' => $totalVenta,
            'total_gravada_formatted' => number_format($totalGravada, 2),
            'total_igv_formatted' => number_format($totalIgv, 2),
            'total_venta_formatted' => number_format($totalVenta, 2),
            'moneda' => $dailySummary->moneda ?? 'PEN',
            'moneda_nombre' => $this->getMonedaNombre($dailySummary->moneda ?? 'PEN'),
        ];
    }
}