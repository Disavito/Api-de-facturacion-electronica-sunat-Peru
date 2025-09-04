<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\BoletaController;
use App\Http\Controllers\Api\DailySummaryController;
use App\Http\Controllers\Api\CreditNoteController;
use App\Http\Controllers\Api\DebitNoteController;
use App\Http\Controllers\Api\PdfController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Rutas de la API SUNAT
Route::prefix('v1')->group(function () {
    
    // PDF Formatos
    Route::prefix('pdf')->group(function () {
        Route::get('/formats', [PdfController::class, 'getAvailableFormats']);
    });
    
    // Facturas
    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::post('/', [InvoiceController::class, 'store']);
        Route::get('/{id}', [InvoiceController::class, 'show']);
        Route::post('/{id}/send-sunat', [InvoiceController::class, 'sendToSunat']);
        Route::get('/{id}/download-xml', [InvoiceController::class, 'downloadXml']);
        Route::get('/{id}/download-cdr', [InvoiceController::class, 'downloadCdr']);
        Route::get('/{id}/download-pdf', [InvoiceController::class, 'downloadPdf']);
        Route::post('/{id}/generate-pdf', [InvoiceController::class, 'generatePdf']);
    });
    
    // Boletas
    Route::prefix('boletas')->group(function () {
        Route::get('/', [BoletaController::class, 'index']);
        Route::post('/', [BoletaController::class, 'store']);
        Route::get('/{id}', [BoletaController::class, 'show']);
        Route::post('/{id}/send-sunat', [BoletaController::class, 'sendToSunat']);
        Route::get('/{id}/download-xml', [BoletaController::class, 'downloadXml']);
        Route::get('/{id}/download-cdr', [BoletaController::class, 'downloadCdr']);
        Route::get('/{id}/download-pdf', [BoletaController::class, 'downloadPdf']);
        Route::post('/{id}/generate-pdf', [BoletaController::class, 'generatePdf']);
        
        // Funciones de resumen diario desde boletas
        Route::get('/pending-for-summary', [BoletaController::class, 'getBoletsasPendingForSummary']);
        Route::post('/create-daily-summary', [BoletaController::class, 'createDailySummaryFromDate']);
        Route::post('/summary/{id}/send-sunat', [BoletaController::class, 'sendSummaryToSunat']);
        Route::post('/summary/{id}/check-status', [BoletaController::class, 'checkSummaryStatus']);
    });

    // Resúmenes Diarios
    Route::prefix('daily-summaries')->group(function () {
        Route::get('/', [DailySummaryController::class, 'index']);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
        Route::post('/', [DailySummaryController::class, 'store']);
        Route::get('/{id}', [DailySummaryController::class, 'show']);
        Route::post('/{id}/send-sunat', [DailySummaryController::class, 'sendToSunat']);
        Route::post('/{id}/check-status', [DailySummaryController::class, 'checkStatus']);
        Route::get('/{id}/download-xml', [DailySummaryController::class, 'downloadXml']);
        Route::get('/{id}/download-cdr', [DailySummaryController::class, 'downloadCdr']);
        Route::get('/{id}/download-pdf', [DailySummaryController::class, 'downloadPdf']);
        Route::post('/{id}/generate-pdf', [DailySummaryController::class, 'generatePdf']);
        
        // Funciones de gestión masiva
        Route::get('/pending', [DailySummaryController::class, 'getPendingSummaries']);
        Route::post('/check-all-pending', [DailySummaryController::class, 'checkAllPendingStatus']);
    });

    // Notas de Crédito
    Route::prefix('credit-notes')->group(function () {
        Route::get('/', [CreditNoteController::class, 'index']);
        Route::post('/', [CreditNoteController::class, 'store']);
        Route::get('/{id}', [CreditNoteController::class, 'show']);
        Route::post('/{id}/send-sunat', [CreditNoteController::class, 'sendToSunat']);
        Route::get('/{id}/download-xml', [CreditNoteController::class, 'downloadXml']);
        Route::get('/{id}/download-cdr', [CreditNoteController::class, 'downloadCdr']);
        Route::get('/{id}/download-pdf', [CreditNoteController::class, 'downloadPdf']);
        Route::post('/{id}/generate-pdf', [CreditNoteController::class, 'generatePdf']);
        
        // Catálogo de motivos
        Route::get('/catalogs/motivos', [CreditNoteController::class, 'getMotivos']);
    });

    // Notas de Débito
    Route::prefix('debit-notes')->group(function () {
        Route::get('/', [DebitNoteController::class, 'index']);
        Route::post('/', [DebitNoteController::class, 'store']);
        Route::get('/{id}', [DebitNoteController::class, 'show']);
        Route::post('/{id}/send-sunat', [DebitNoteController::class, 'sendToSunat']);
        Route::get('/{id}/download-xml', [DebitNoteController::class, 'downloadXml']);
        Route::get('/{id}/download-cdr', [DebitNoteController::class, 'downloadCdr']);
        Route::get('/{id}/download-pdf', [DebitNoteController::class, 'downloadPdf']);
        Route::post('/{id}/generate-pdf', [DebitNoteController::class, 'generatePdf']);
        
        // Catálogo de motivos
        Route::get('/catalogs/motivos', [DebitNoteController::class, 'getMotivos']);
    });
    
});