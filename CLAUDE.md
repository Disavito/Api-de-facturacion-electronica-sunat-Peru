# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel-based API for electronic invoicing with SUNAT (Peru's tax administration). It provides endpoints to generate, send, and manage various electronic documents including invoices, boletas, credit notes, debit notes, dispatch guides, and daily summaries.

## Core Architecture

### Key Dependencies
- **Greenter Library**: Core SUNAT integration library for document generation and submission
  - `greenter/greenter`: Main library for document processing
  - `greenter/xmldsig`: XML digital signature handling
  - `greenter/ws`: Web service communication
  - `greenter/zip`: ZIP file handling for SUNAT communications
- **Laravel Sanctum**: API authentication
- **DomPDF**: PDF generation for documents

### Application Structure

#### Controllers (app/Http/Controllers/Api/)
- `InvoiceController`: Handles invoices (facturas)
- `BoletaController`: Handles boletas and daily summary operations
- `CreditNoteController`: Credit notes with motivo catalogs
- `DebitNoteController`: Debit notes with motivo catalogs  
- `DailySummaryController`: Daily summaries with batch processing
- `DispatchGuideController`: Dispatch guides (guías de remisión)

#### Services (app/Services/)
- `GreenterService`: Core integration with Greenter library (57KB - main service)
- `DocumentService`: Document management and processing
- `FileService`: File operations for XML/PDF/CDR
- `PdfService`: PDF generation using DomPDF

#### Models (app/Models/)
Core entities: Company, Client, Branch, Invoice, Boleta, CreditNote, DebitNote, DailySummary, DispatchGuide, Correlative

## Common Development Commands

### Backend (PHP/Laravel)
```bash
# Install dependencies
composer install

# Run tests
./vendor/bin/phpunit

# Code style
./vendor/bin/pint

# Start development server
php artisan serve

# Database migrations
php artisan migrate

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Frontend (Vite/Tailwind)
```bash
# Install dependencies
npm install

# Development server
npm run dev

# Build for production
npm run build
```

## API Structure

All API routes are under `/api/v1/` prefix with the following main endpoints:
- `/invoices` - Invoice operations with SUNAT integration
- `/boletas` - Boletas with daily summary creation
- `/credit-notes` - Credit notes with motivo catalogs
- `/debit-notes` - Debit notes with motivo catalogs
- `/daily-summaries` - Batch summary processing and status checking
- `/dispatch-guides` - Dispatch guide management

Each document type supports:
- CRUD operations
- SUNAT submission (`/send-sunat`)
- File downloads (XML, CDR, PDF)
- Status checking for summaries

## SUNAT Integration

Documents are processed through the GreenterService which handles:
- Document validation and structure
- XML generation with digital signatures
- SUNAT web service communication
- Response processing (CDR files)
- Certificate management

## Database Configuration

Uses MySQL by default. Test environment configured for SQLite in-memory database.

## Environment Setup

Key environment variables needed:
- Database connection (MySQL)
- SUNAT certificates and credentials
- File storage paths
- API endpoints (production/beta modes)