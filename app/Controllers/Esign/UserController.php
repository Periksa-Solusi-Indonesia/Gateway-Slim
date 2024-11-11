<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    public function registerUser(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nama = $parsedBody['nama'] ?? '';
        $email = $parsedBody['email'] ?? '';
        $oidInstansi = $parsedBody['oid_instansi'] ?? '';
        $suratRekomendasiBase64 = $parsedBody['suratRekomendasiBase64'] ?? 'NULL';

        $requestData = [
            'nama' => $nama,
            'email' => $email,
            'oid_instansi' => $oidInstansi,
            'suratRekomendasiBase64' => $suratRekomendasiBase64
        ];
        $client = new Client();

        try {
            $apiResponse = $client->post('https://esign-dev.jakarta.go.id/api/v2/user/registration', [
                'json' => $requestData
            ]);

            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            $errorResponse = [
                'status' => 'error',
                'message' => 'Gagal melakukan registrasi: ' . $e->getMessage()
            ];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function checkStatusByNik(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nik = $parsedBody['nik'] ?? '';
        $requestData = [
            'nik' => $nik
        ];

        $client = new Client();

        try {
            $apiResponse = $client->post('https://esign-dev.jakarta.go.id/api/v2/user/check/status', [
                'json' => $requestData
            ]);
            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            $errorResponse = [
                'status' => 'error',
                'message' => 'Gagal memeriksa status NIK: ' . $e->getMessage()
            ];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function getCertificateChainByNik(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? '';

        $client = new Client();

        try {
            $apiResponse = $client->get("https://esign-dev.jakarta.go.id/api/v2/user/certificate/chain/{$id}");
            $apiResponseBody = $apiResponse->getBody()->getContents();

            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            $errorResponse = [
                'status' => 'error',
                'message' => 'Gagal mengambil certificate chain: ' . $e->getMessage()
            ];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
