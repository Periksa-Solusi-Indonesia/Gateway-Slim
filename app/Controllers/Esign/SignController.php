<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SignController
{
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
            $apiResponse = $client->post('https://esign-dev.jakarta.go.id/api/v2/sign/get/totp', [
                'json' => $requestData
            ]);

            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            $errorResponse = [
                'status' => 'error',
                'message' => 'Gagal meminta OTP: ' . $e->getMessage()
            ];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function signPdfByNik(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nik = $parsedBody['nik'] ?? '';
        $totp = $parsedBody['totp'] ?? '';
        $imageTtdBase64 = $parsedBody['image_ttd_base64'] ?? '';
        $pdfBase64 = $parsedBody['pdf_2_kb'] ?? '';

        $signatureProperties = [
            [
                'imageBase64' => $imageTtdBase64,
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
            $apiResponse = $client->post('https://esign-dev.jakarta.go.id/api/v2/sign/pdf', [
                'json' => $requestData
            ]);

            $apiResponseBody = $apiResponse->getBody()->getContents();
            $response->getBody()->write($apiResponseBody);
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            $errorResponse = [
                'status' => 'error',
                'message' => 'Gagal menandatangani PDF: ' . $e->getMessage()
            ];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
