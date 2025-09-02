<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('daily_summaries', function (Blueprint $table) {
            // Eliminar columnas del esquema antiguo
            $table->dropColumn([
                'tipo_documento',
                'identificador', 
                'fecha_emision',
                'total_documentos',
                'total_gravadas',
                'total_exoneradas',
                'total_inafectas',
                'total_gratuitas',
                'total_igv',
                'total_isc',
                'total_icbper',
                'total_otros_tributos',
                'total_venta'
            ]);
            
            // Renombrar fecha_referencia a fecha_resumen
            $table->renameColumn('fecha_referencia', 'fecha_resumen');
            
            // Agregar nuevas columnas
            $table->date('fecha_generacion')->after('correlativo');
            $table->string('numero_completo', 50)->nullable()->after('correlativo');
            $table->string('ubl_version', 5)->default('2.1')->change();
            $table->string('estado_proceso', 20)->default('GENERADO')->after('moneda');
            $table->string('pdf_path')->nullable()->after('cdr_path');
            $table->string('codigo_hash')->nullable()->after('ticket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_summaries', function (Blueprint $table) {
            // Revertir los cambios
            $table->renameColumn('fecha_resumen', 'fecha_referencia');
            $table->dropColumn([
                'fecha_generacion',
                'numero_completo',
                'estado_proceso',
                'pdf_path',
                'codigo_hash'
            ]);
            
            // Restaurar columnas eliminadas
            $table->string('tipo_documento', 2)->default('RC');
            $table->string('identificador', 20);
            $table->date('fecha_emision');
            $table->integer('total_documentos')->default(0);
            $table->decimal('total_gravadas', 12, 2)->default(0);
            $table->decimal('total_exoneradas', 12, 2)->default(0);
            $table->decimal('total_inafectas', 12, 2)->default(0);
            $table->decimal('total_gratuitas', 12, 2)->default(0);
            $table->decimal('total_igv', 12, 2)->default(0);
            $table->decimal('total_isc', 12, 2)->default(0);
            $table->decimal('total_icbper', 12, 2)->default(0);
            $table->decimal('total_otros_tributos', 12, 2)->default(0);
            $table->decimal('total_venta', 12, 2)->default(0);
            $table->string('ubl_version', 3)->default('2.0')->change();
        });
    }
};
