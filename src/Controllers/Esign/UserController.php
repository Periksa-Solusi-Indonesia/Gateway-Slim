<?php

namespace App\Controllers\Esign;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    private function handleApiError($e, Response $response)
    {
        if ($e instanceof ClientException || $e instanceof ServerException) {
            $apiResponse = $e->getResponse();
            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        }
        $errorResponse = [
            'status' => 'error',
            'message' => 'Gagal melakukan permintaan ke API: ' . $e->getMessage(),
        ];
        $response->getBody()->write(json_encode($errorResponse));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }

    public function registerUser(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nama = $parsedBody['nama'] ?? '';
        $email = $parsedBody['email'] ?? '';
        $oidInstansi = $parsedBody['oid_instansi'] ?? '';
        $suratRekomendasiBase64 = $parsedBody['suratRekomendasiBase64'] ?? 'NULL';
        $reqBodyUrl = $parsedBody['url'] ?? 'https://esign-dev.layanan.go.id';
        $requestData = [
            'nama' => $nama,
            'email' => $email,
            'oid_instansi' => $oidInstansi,
            'suratRekomendasiBase64' => $suratRekomendasiBase64
        ];
        $client = new Client();

        try {
            $apiUrl = $reqBodyUrl . '/api/v2/user/registration';
            $apiResponse = $client->post($apiUrl, [
                'json' => $requestData,
                'auth' => ['esign', 'wrjcgX6526A2dCYSAV6u'],
            ]);

            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            return $this->handleApiError($e, $response);
        }
    }

    public function checkStatusByNik(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nik = $parsedBody['nik'] ?? '';
        $reqBodyUrl = $parsedBody['url'] ?? 'https://esign-dev.layanan.go.id';
        $requestData = [
            'nik' => $nik
        ];

        $client = new Client();

        try {
            $apiUrl = $reqBodyUrl . '/api/v2/user/check/status';
            $apiResponse = $client->post($apiUrl, [
                'json' => $requestData,
                'auth' => ['esign', 'wrjcgX6526A2dCYSAV6u'],
            ]);
            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            return $this->handleApiError($e, $response);
        }
    }

    public function getCertificateChainByNik(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();
        $reqBodyUrl = $parsedBody['url'] ?? 'https://esign-dev.layanan.go.id';
        $id = $args['id'] ?? '';

        $client = new Client();

        try {
            $apiUrl = $reqBodyUrl . "/api/v2/user/certificate/chain/{$id}";
            $apiResponse = $client->get($apiUrl, [
                'auth' => ['esign', 'wrjcgX6526A2dCYSAV6u'],
            ]);
            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            return $this->handleApiError($e, $response);
        }
    }
}
