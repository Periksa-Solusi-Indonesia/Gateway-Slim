<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VerifyController
{
    public function verifyPdf(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $file = $parsedBody['file'] ?? '';

        $requestData = [
            'file' => $file
        ];

        $client = new Client();

        try {
            $apiResponse = $client->post('https://esign-dev.jakarta.go.id/api/v2/verify/pdf', [
                'json' => $requestData
            ]);

            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            $errorResponse = [
                'status' => 'error',
                'message' => 'Gagal Verifikasi PDF: ' . $e->getMessage()
            ];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
