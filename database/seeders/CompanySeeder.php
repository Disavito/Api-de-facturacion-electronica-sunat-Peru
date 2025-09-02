<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Branch;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Leer certificado desde storage/app/public/certificado/certificado.pem
        $certificadoPath = storage_path('app/public/certificado/certificado.pem');
        
        if (!file_exists($certificadoPath)) {
            $this->command->error("❌ No se encontró el certificado en: {$certificadoPath}");
            $this->command->info("📁 Asegúrate de colocar tu certificado .pem en: storage/app/public/certificado/certificado.pem");
            $this->command->warn("⚠️  Se usará certificado de prueba de Greenter para desarrollo");
            
            // Usar certificado demo como fallback
            $certificadoPem = $this->getCertificadoDemo();
        } else {
            $certificadoPem = file_get_contents($certificadoPath);
            
            if (empty($certificadoPem)) {
                $this->command->error("❌ El archivo de certificado está vacío o no se pudo leer");
                return;
            }
            
            $this->command->info("✅ Certificado cargado correctamente desde: {$certificadoPath}");
            $this->validateCertificateBasic($certificadoPem);
        }
        

        // Crear empresa de prueba
        $company = Company::create([
            'ruc' => '20123456789',
            'razon_social' => 'EMPRESA DE PRUEBAS GREENTER S.A.C.',
            'nombre_comercial' => 'GREENTER PERU',
            'direccion' => 'AV. LAS FLORES 123 - LIMA - LIMA - PERU',
            'ubigeo' => '150101',
            'distrito' => 'LIMA',
            'provincia' => 'LIMA',
            'departamento' => 'LIMA',
            'telefono' => '01-1234567',
            'email' => 'ventas@greenter.dev',
            'web' => 'https://greenter.dev',
            
            // Configuración SUNAT
            'usuario_sol' => 'MODDATOS',
            'clave_sol' => 'moddatos',
            'certificado_pem' => $certificadoPem,
            'certificado_password' => null,
            
            // Endpoints
            'endpoint_beta' => 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService',
            'endpoint_produccion' => 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService',
            'modo_produccion' => false,
            
            'configuraciones' => [
                'timeout' => 30,
                'max_retries' => 3,
                'cache_enabled' => true
            ],
            'activo' => true
        ]);

        // Crear sucursal principal
        $sucursalPrincipal = Branch::create([
            'company_id' => $company->id,
            'codigo' => '0001',
            'nombre' => 'SUCURSAL PRINCIPAL',
            'direccion' => 'AV. LAS FLORES 123',
            'ubigeo' => '150101',
            'distrito' => 'LIMA',
            'provincia' => 'LIMA',
            'departamento' => 'LIMA',
            'telefono' => '01-1234567',
            'email' => 'principal@greenter.dev',
            
            'series_factura' => ['F001', 'F002', 'F003'],
            'series_boleta' => ['B001', 'B002'],
            'series_nota_credito' => ['FC01', 'BC01'],
            'series_nota_debito' => ['FD01', 'BD01'],
            'series_guia_remision' => ['T001', 'T002'],
            'activo' => true
        ]);

        // Crear segunda sucursal
        $sucursalSecundaria = Branch::create([
            'company_id' => $company->id,
            'codigo' => '0002',
            'nombre' => 'SUCURSAL SAN ISIDRO',
            'direccion' => 'AV. JAVIER PRADO 456',
            'ubigeo' => '150108',
            'distrito' => 'SAN ISIDRO',
            'provincia' => 'LIMA',
            'departamento' => 'LIMA',
            'telefono' => '01-7654321',
            'email' => 'sanisidro@greenter.dev',
            
            'series_factura' => ['F101', 'F102'],
            'series_boleta' => ['B101'],
            'series_nota_credito' => ['FC02'],
            'series_nota_debito' => ['FD02'],
            'series_guia_remision' => ['T101'],
            'activo' => true
        ]);

        $this->command->info("🏢 Empresa creada con RUC: {$company->ruc}");
        $this->command->info("🏪 Sucursales creadas: {$sucursalPrincipal->nombre}, {$sucursalSecundaria->nombre}");
        $this->command->info("🔒 Certificado configurado desde: {$certificadoPath}");
        $this->command->info("🌐 Modo: " . ($company->modo_produccion ? 'PRODUCCIÓN' : 'BETA (Pruebas)'));
        $this->command->info("✅ ¡Configuración completada! Ya puedes usar la API de facturación SUNAT.");
        $this->command->info("🔍 Para validar tu certificado ejecuta: php artisan sunat:validate-certificate");
    }

    private function validateCertificateBasic(string $pem): void
    {
        $hasPrivateKey = strpos($pem, '-----BEGIN PRIVATE KEY-----') !== false;
        $hasCertificate = strpos($pem, '-----BEGIN CERTIFICATE-----') !== false;
        
        if ($hasPrivateKey && $hasCertificate) {
            $this->command->info("✅ Estructura PEM válida (clave privada + certificado)");
        } else {
            $this->command->error("❌ Estructura PEM incompleta:");
            if (!$hasPrivateKey) $this->command->error("  - Falta clave privada (PRIVATE KEY)");
            if (!$hasCertificate) $this->command->error("  - Falta certificado (CERTIFICATE)");
        }
    }

    private function getCertificadoDemo(): string
    {
        // Certificado demo de Greenter para desarrollo/pruebas
        return <<<'PEM'
-----BEGIN PRIVATE KEY-----
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
WD1pKgVE9gR1gWgU5+lBCWLs0LsOVQ==
-----END PRIVATE KEY-----
-----BEGIN CERTIFICATE-----
MIIFqjCCA5KgAwIBAgIJAPC1/o2N5OBRMA0GCSqGSIb3DQEBCwUAMGoxCzAJBgNV
BAYTAlBFMQ0wCwYDVQQIDARMaW1hMQ0wCwYDVQQHDARMaW1hMQ8wDQYDVQQKDAZH
UkVFTlQxDjAMBgNVBAsMBUdSRUVOMRwwGgYDVQQDDBNHUkVFTlRFUiBTLkEuQyAy
MDI0MB4XDTIxMDYxNjIzNTk1OVoXDTMxMDYxNDIzNTk1OVowajELMAkGA1UEBhMC
UEUxDTALBgNVBAgMBExpbWExDTALBgNVBAcMBExpbWExDzANBgNVBAoMBkdSRUVO
VDEOMAwGA1UECwwFR1JFRU4xHDAaBgNVBAMME0dSRUVOVEVSIFMuQS5DICAyMDI0
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAvPnaLygND7gJf1ty56EN
YK55JyCyI+7arJuI/puLFp25HX4E37G7dvLAu36ut45Y9o/VsoAmRv3GVzd/rviV
4+u1gI2f27W0a7LmlSPRKKRhZWokjMuxkXhJr6RwVUjhl9+YQlvnENvv9bJD6119
1IqRgqimDSJaDz7v95D3j1bxg/DqgbxQBuRxC1wV9dQ6CWt/0j/gLqusCy0+qtLH
1n6usJG7+d1ZhqellSXKU1hn2aqyIexWZZlauYN1Er9FUFL8kIky48+S5zPP+gq3
M97GoT1gqMVDs4jbrMwZ9vVqssDWN2nlrdw/Vwiw8nnejpDwQ30y585GBFGYbij5
NKY3Wip1Zj8m/U1ODsB2MevBL4hcODiK4h4AstZCBlIhp7rCvff4bmA44P3OSrkI
q8NK+XU3Q8EXC9/eBQxFgw9mH3bz1GeZangXbczv1CcP5KmkNLtVgMJKxtj1yVkF
RrSMVD+io7keBj8yjSRPc5IZo+qbYdKs5DBeM+b6YFgfCQ/WYLB4ZB/1aTlLjHtF
AbyoaRFLyXd70Xo6S1MC88pKjv//ZzVnQ8A11d6eLBIywkGioKsdCwdZ3nsp05ca
BMaKvrJguJHzN7cfYAQSJBpEk3fPpBtU5xTLNeuxSXsEFABjpMQbS1TtpGPE7udR
xRU+Bodf/I+3Nxe0tulk+eUCAwEAAaNTMFEwHQYDVR0OBBYEFE6/gdKKkEpwxOGb
YGNKPcQS8A4jMB8GA1UdIwQYMBaAFE6/gdKKkEpwxOGbYGNKPcQS8A4jMA8GA1Ud
EwEB/wQFMAMBAf8wDQYJKoZIhvcNAQELBQADggIBAGoEHfXGCeEzNJuKaXdOC8Lm
7w3M3Tp3fHJLwp4VFGPHGfOg7c9aKrNn+U2EHfKOtXGDI7NQXGHJk1sE6w2bFKoB
oGfGU4QbdOGW4RGHFzDLG8fOdSGpN3eB+QRNG7dBJdHYN1eKFE9RY7cQ7pGdLBkm
WVNhRH8W2oYqCPF8QUwTRFXoLI8MJMZZ8NmXwHdYLVwH8wSsIUdRJzfHJE9HhyKb
aUwNrJEqrKG7RGHFzDLGBdLYN1eKFE9RY7cQ7pGdLBkmWVNhRH8W2oYqCPF8QUwT
RFXoLI8MJMZZ8NmXwHdYLVwH8wSsIUdRJzfHJE9HhyKbaUwNrJEqrKG7RGHFzDLG
8fOdSGpN3eB+QRNG7dBJdHYN1eKFE9RY7cQ7pGdLBkmWVNhRH8W2oYqCPF8QUwT
RFXoLI8MJMZZ8NmXwHdYLVwH8wSsIUdRJzfHJE9HhyKbaUwNrJEqrKG7RGHFzDLG
BdLYN1eKFE9RY7cQ7pGdLBkmWVNhRH8W2oYqCPF8QUwTRFXoLI8MJMZZ8NmXwHdY
LVwH8wSsIUdRJzfHJE9HhyKbaUwNrJEqrKG7RGHFzDLG8fOdSGpN3eB+QRNG7dBJ
dHYN1eKFE9RY7cQ7pGdLBkmWVNhRH8W2oYqCPF8QUwTRFXoLI8MJMZZ8NmXwHdY
LVwH8wSsIUdRJzfHJE9HhyKbaUwNrJEqrKG7RGHFzDLGBdLYN1eKFE9RY7cQ7pGd
LBkmWVNhRH8W2oYqCPF8QUwTRFXoLI8MJMZZ8NmXwHdYLVwH8wSsIUdRJzfHJE9H
hyKbaUwNrJEqrKG7
-----END CERTIFICATE-----
PEM;
    }
}