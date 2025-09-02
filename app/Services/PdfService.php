<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class PdfService
{
    public function generateInvoicePdf($invoice): string
    {
        $data = $this->prepareInvoiceData($invoice);
        
        $html = View::make('pdf.invoice', $data)->render();
        
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->output();
    }

    public function generateBoletaPdf($boleta): string
    {
        $data = $this->prepareBoletaData($boleta);
        
        $html = View::make('pdf.boleta', $data)->render();
        
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->output();
    }

    public function generateCreditNotePdf($creditNote): string
    {
        $data = $this->prepareCreditNoteData($creditNote);
        
        $html = View::make('pdf.credit-note', $data)->render();
        
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->output();
    }

    public function generateDebitNotePdf($debitNote): string
    {
        $data = $this->prepareDebitNoteData($debitNote);
        
        $html = View::make('pdf.debit-note', $data)->render();
        
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->output();
    }

    public function generateDispatchGuidePdf($dispatchGuide): string
    {
        $data = $this->prepareDispatchGuideData($dispatchGuide);
        
        $html = View::make('pdf.dispatch-guide', $data)->render();
        
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->output();
    }

    protected function prepareInvoiceData($invoice): array
    {
        return [
            'document' => $invoice,
            'company' => $invoice->company,
            'branch' => $invoice->branch,
            'client' => $invoice->client_data ?? json_decode($invoice->client_json, true),
            'detalles' => $invoice->detalles ?? json_decode($invoice->detalles_json, true),
            'totales' => $this->calculateInvoiceTotals($invoice),
            'fecha_emision' => $invoice->fecha_emision->format('d/m/Y'),
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
        $detalles = $invoice->detalles ?? json_decode($invoice->detalles_json, true);
        
        $subtotal = 0;
        $igv = 0;
        $total = 0;

        if ($detalles) {
            foreach ($detalles as $detalle) {
                $valorVenta = $detalle['mto_valor_venta'] ?? ($detalle['cantidad'] * $detalle['mto_valor_unitario']);
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
}