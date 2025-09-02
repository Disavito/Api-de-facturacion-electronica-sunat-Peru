<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FileService
{
    public function saveXml($document, string $xmlContent): string
    {
        $path = $this->generatePath($document, 'xml');
        Storage::disk('public')->put($path, $xmlContent);
        return $path;
    }

    public function saveCdr($document, string $cdrContent): string
    {
        $path = $this->generatePath($document, 'zip');
        Storage::disk('public')->put($path, $cdrContent);
        return $path;
    }

    public function savePdf($document, string $pdfContent): string
    {
        $path = $this->generatePath($document, 'pdf');
        Storage::disk('public')->put($path, $pdfContent);
        return $path;
    }

    protected function generatePath($document, string $extension): string
    {
        $date = Carbon::parse($document->fecha_emision);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        
        $companyRuc = $document->company->ruc;
        $fileName = $document->numero_completo;
        
        // Obtener tipo de comprobante
        $tipoComprobante = $this->getDocumentTypeName($document);
        
        // Crear estructura: comprobantes/TIPO_COMPROBANTE/RUC/YYYY/MM/DD/
        $directory = "comprobantes/{$tipoComprobante}/{$companyRuc}/{$year}/{$month}/{$day}";
        
        // Prefijo según tipo de archivo
        $prefix = '';
        if ($extension === 'zip') {
            $prefix = 'R-'; // CDR
        }
        
        return "{$directory}/{$prefix}{$fileName}.{$extension}";
    }

    protected function getDocumentTypeName($document): string
    {
        // Determinar el nombre de la carpeta según el tipo de documento
        if (property_exists($document, 'tipo_documento')) {
            return match($document->tipo_documento) {
                '01' => 'facturas',
                '03' => 'boletas',
                '07' => 'notas-credito',
                '08' => 'notas-debito',
                '09' => 'guias-remision',
                '20' => 'percepciones',
                '21' => 'retenciones',
                default => 'otros-comprobantes'
            };
        }
        
        // Fallback basado en el nombre de la clase del modelo
        $className = class_basename($document);
        return match($className) {
            'Factura' => 'facturas',
            'Boleta' => 'boletas',
            'CreditNote' => 'notas-credito',
            'DebitNote' => 'notas-debito', 
            'DispatchGuide' => 'guias-remision',
            'Percepcion' => 'percepciones',
            'Retencion' => 'retenciones',
            'DailySummary' => 'resumenes-diarios',
            default => 'otros-comprobantes'
        };
    }

    public function getXmlPath($document): ?string
    {
        if (!$document->xml_path) {
            return null;
        }
        
        return Storage::disk('public')->exists($document->xml_path) 
            ? Storage::disk('public')->path($document->xml_path)
            : null;
    }

    public function getCdrPath($document): ?string
    {
        if (!$document->cdr_path) {
            return null;
        }
        
        return Storage::disk('public')->exists($document->cdr_path)
            ? Storage::disk('public')->path($document->cdr_path)
            : null;
    }

    public function getPdfPath($document): ?string
    {
        if (!$document->pdf_path) {
            return null;
        }
        
        return Storage::disk('public')->exists($document->pdf_path)
            ? Storage::disk('public')->path($document->pdf_path)
            : null;
    }

    public function downloadXml($document)
    {
        if (!$document->xml_path || !Storage::disk('public')->exists($document->xml_path)) {
            return null;
        }
        
        return Storage::disk('public')->download(
            $document->xml_path,
            $document->numero_completo . '.xml'
        );
    }

    public function downloadCdr($document)
    {
        if (!$document->cdr_path || !Storage::disk('public')->exists($document->cdr_path)) {
            return null;
        }
        
        return Storage::disk('public')->download(
            $document->cdr_path,
            'R-' . $document->numero_completo . '.zip'
        );
    }

    public function downloadPdf($document)
    {
        if (!$document->pdf_path || !Storage::disk('public')->exists($document->pdf_path)) {
            return null;
        }
        
        return Storage::disk('public')->download(
            $document->pdf_path,
            $document->numero_completo . '.pdf'
        );
    }

    public function createDirectoryStructure(string $ruc): void
    {
        // Tipos de comprobantes
        $tiposComprobantes = [
            'facturas',
            'boletas', 
            'notas-credito',
            'notas-debito',
            'guias-remision',
            'percepciones',
            'retenciones',
            'resumenes-diarios',
            'otros-comprobantes'
        ];
        
        // Crear estructura de directorios para el año actual
        $currentYear = Carbon::now()->format('Y');
        
        foreach ($tiposComprobantes as $tipoComprobante) {
            $baseDir = "comprobantes/{$tipoComprobante}/{$ruc}";
            
            for ($month = 1; $month <= 12; $month++) {
                $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);
                
                // Crear directorio del mes
                $monthDir = "{$baseDir}/{$currentYear}/{$monthStr}";
                Storage::disk('public')->makeDirectory($monthDir);
                
                // Crear algunos directorios de días comunes
                for ($day = 1; $day <= 31; $day++) {
                    $dayStr = str_pad($day, 2, '0', STR_PAD_LEFT);
                    $dayDir = "{$monthDir}/{$dayStr}";
                    Storage::disk('public')->makeDirectory($dayDir);
                }
            }
        }
    }
}