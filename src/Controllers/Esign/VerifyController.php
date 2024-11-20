<?php

namespace App\Controllers\Esign;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VerifyController
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

    public function verifyPdf(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $file = $parsedBody['file'] ?? '';

        $requestData = [
            'file' => $file
        ];

        $client = new Client();

        try {
            $apiResponse = $client->post('https://esign-dev.layanan.go.id/api/v2/verify/pdf', [
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
}
