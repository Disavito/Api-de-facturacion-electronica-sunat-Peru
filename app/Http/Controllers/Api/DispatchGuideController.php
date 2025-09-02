<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DocumentService;
use App\Services\FileService;
use App\Models\DispatchGuide;
use App\Http\Requests\IndexDispatchGuideRequest;
use App\Http\Requests\StoreDispatchGuideRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DispatchGuideController extends Controller
{
    protected $documentService;
    protected $fileService;

    public function __construct(DocumentService $documentService, FileService $fileService)
    {
        $this->documentService = $documentService;
        $this->fileService = $fileService;
    }

    public function index(IndexDispatchGuideRequest $request): JsonResponse
    {
        try {
            $query = DispatchGuide::with(['company', 'branch', 'destinatario']);

            // Filtros
            if ($request->has('company_id')) {
                $query->where('company_id', $request->company_id);
            }

            if ($request->has('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }

            if ($request->has('estado_sunat')) {
                $query->where('estado_sunat', $request->estado_sunat);
            }

            if ($request->has('cod_traslado')) {
                $query->where('cod_traslado', $request->cod_traslado);
            }

            if ($request->has('mod_traslado')) {
                $query->where('mod_traslado', $request->mod_traslado);
            }

            if ($request->has('fecha_desde') && $request->has('fecha_hasta')) {
                $query->whereBetween('fecha_emision', [
                    $request->fecha_desde,
                    $request->fecha_hasta
                ]);
            }

            // Paginación
            $perPage = $request->get('per_page', 15);
            $dispatchGuides = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $dispatchGuides,
                'message' => 'Guías de remisión obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las guías de remisión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreDispatchGuideRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            // Crear la guía de remisión
            $dispatchGuide = $this->documentService->createDispatchGuide($validated);

            return response()->json([
                'success' => true,
                'data' => $dispatchGuide->load(['company', 'branch', 'destinatario']),
                'message' => 'Guía de remisión creada correctamente'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la guía de remisión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $dispatchGuide = DispatchGuide::with(['company', 'branch', 'destinatario'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $dispatchGuide,
                'message' => 'Guía de remisión obtenida correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Guía de remisión no encontrada',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function sendToSunat($id): JsonResponse
    {
        try {
            $dispatchGuide = DispatchGuide::with(['company', 'branch', 'destinatario'])->findOrFail($id);

            if ($dispatchGuide->estado_sunat === 'ACEPTADO') {
                return response()->json([
                    'success' => false,
                    'message' => 'La guía de remisión ya fue enviada y aceptada por SUNAT'
                ], 400);
            }

            $result = $this->documentService->sendDispatchGuideToSunat($dispatchGuide);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'data' => $result['document'],
                    'ticket' => $result['ticket'] ?? null,
                    'message' => 'Guía de remisión enviada correctamente a SUNAT'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => $result['document'],
                    'message' => 'Error al enviar guía a SUNAT',
                    'error' => $result['error'] ?? 'Error desconocido'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el envío a SUNAT',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus($id): JsonResponse
    {
        try {
            $dispatchGuide = DispatchGuide::with(['company', 'branch', 'destinatario'])->findOrFail($id);

            if (empty($dispatchGuide->ticket)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La guía no tiene un ticket para consultar'
                ], 400);
            }

            $result = $this->documentService->checkDispatchGuideStatus($dispatchGuide);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'data' => $result['document'],
                    'message' => 'Estado de la guía consultado correctamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al consultar estado: ' . ($result['error'] ?? 'Error desconocido')
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadXml($id)
    {
        try {
            $dispatchGuide = DispatchGuide::findOrFail($id);
            
            $download = $this->fileService->downloadXml($dispatchGuide);
            
            if (!$download) {
                return response()->json([
                    'success' => false,
                    'message' => 'XML no encontrado'
                ], 404);
            }
            
            return $download;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al descargar XML',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadCdr($id)
    {
        try {
            $dispatchGuide = DispatchGuide::findOrFail($id);
            
            $download = $this->fileService->downloadCdr($dispatchGuide);
            
            if (!$download) {
                return response()->json([
                    'success' => false,
                    'message' => 'CDR no encontrado'
                ], 404);
            }
            
            return $download;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al descargar CDR',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadPdf($id)
    {
        try {
            $dispatchGuide = DispatchGuide::findOrFail($id);
            
            $download = $this->fileService->downloadPdf($dispatchGuide);
            
            if (!$download) {
                return response()->json([
                    'success' => false,
                    'message' => 'PDF no encontrado'
                ], 404);
            }
            
            return $download;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al descargar PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}