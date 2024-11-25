<?php

namespace App\Controllers\Esign;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SignController
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

    public function requestOtpByNik(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nik = $parsedBody['nik'] ?? '';
        $data = $parsedBody['data'] ?? 1;

        $requestData = [
            'nik' => $nik,
            'data' => $data
        ];

        $client = new Client();

        try {
            $apiResponse = $client->post('https://esign-dev.layanan.go.id/api/v2/sign/get/totp', [
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

    public function signPdfByNik(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nik = $parsedBody['nik'] ?? '';
        $totp = $parsedBody['totp'] ?? '';
        $pdfBase64 = $parsedBody['file'] ?? '';

        $signatureProperties = [
            [
                'imageBase64' => $parsedBody['imageBase64'],
                'tampilan' => $parsedBody['tampilan'] ?? '',
                'page' => $parsedBody['page'] ?? '',
                'originX' => $parsedBody['originX'] ?? '',
                'originY' => $parsedBody['originY'] ?? '',
                'width' => $parsedBody['width'] ?? '',
                'height' => $parsedBody['height'] ?? '',
                'location' => $parsedBody['location'] ?? '',
                'reason' => $parsedBody['reason'] ?? '',
                'contactInfo' => $parsedBody['contactInfo'] ?? ''
            ]
        ];

        $requestData = [
            'nik' => $nik,
            'totp' => $totp,
            'signatureProperties' => $signatureProperties,
            'file' => [$pdfBase64]
        ];

        $client = new Client();

        try {
            $apiResponse = $client->post('https://esign-dev.layanan.go.id/api/v2/sign/pdf', [
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
