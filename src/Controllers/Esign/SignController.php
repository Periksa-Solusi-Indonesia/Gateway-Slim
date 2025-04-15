<?php

namespace App\Controllers\Esign;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\BsreLog; 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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
        $reqBodyUrl = $parsedBody['url'] ?? 'https://esign-dev.layanan.go.id';

        $requestData = [
            'nik' => $nik,
            'data' => $data
        ];

        $client = new Client();

        try {
            $apiUrl = $reqBodyUrl . '/api/v2/sign/get/totp';
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

    public function signPdfByNik(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nik = $parsedBody['nik'] ?? '';
        $totp = $parsedBody['totp'] ?? '';
        $pdfBase64 = $parsedBody['file'] ?? [];
        $reqBodyUrl = $parsedBody['url'] ?? 'https://esign-dev.layanan.go.id';

        $signatureProperties = $parsedBody['signatureProperties'] ?? [];
        $formattedSignatureProperties = [];

        foreach ($signatureProperties as $property) {
            $formattedSignatureProperties[] = [
                'imageBase64' => $property['imageBase64'] ?? '',
                'tampilan' => $property['tampilan'] ?? '',
                'page' => $property['page'] ?? '',
                'originX' => $property['originX'] ?? '',
                'originY' => $property['originY'] ?? '',
                'width' => $property['width'] ?? '',
                'height' => $property['height'] ?? '',
                'location' => $property['location'] ?? '',
                'reason' => $property['reason'] ?? '',
                'contactInfo' => $property['contactInfo'] ?? ''
            ];
        }

        $requestData = [
            'nik' => $nik,
            'totp' => $totp,
            'signatureProperties' => $formattedSignatureProperties,
            'file' => $pdfBase64
        ];
        $client = new Client();

        try {
            $apiUrl = $reqBodyUrl . '/api/v2/sign/pdf';
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
    public function signPdfByNikPassphrase(Request $request, Response $response)
    {
        $parsedBody = $request->getParsedBody();
        $nik = $parsedBody['nik'] ?? '';
        $passphrase = $parsedBody['passphrase'] ?? '';
        $pdfVisibleWithImageTtd = $parsedBody['file'] ?? [];
        $reqBodyUrl = $parsedBody['url'] ?? 'https://esign-dev.layanan.go.id';
        $username = $parsedBody['username'] ?? 'esign';
        $password = $parsedBody['password'] ?? 'wrjcgX6526A2dCYSAV6u';
        $namaFormulir = $parsedBody['nama_formulir'] ?? null;
        $typeFormulir = $parsedBody['type_formulir'] ?? null;


        $signatureProperties = $parsedBody['signatureProperties'] ?? [];
        $formattedSignatureProperties = [];

        foreach ($signatureProperties as $property) {
            $formattedSignatureProperties[] = [
                'imageBase64' => $property['imageBase64'] ?? '',
                'tampilan' => $property['tampilan'] ?? '',
                'page' => $property['page'] ?? '',
                'originX' => $property['originX'] ?? '',
                'originY' => $property['originY'] ?? '',
                'width' => $property['width'] ?? '',
                'height' => $property['height'] ?? '',
                'location' => $property['location'] ?? '',
                'reason' => $property['reason'] ?? '',
                'contactInfo' => $property['contactInfo'] ?? ''
            ];
        }

        $requestData = [
            'nik' => $nik,
            'passphrase' => $passphrase,
            'signatureProperties' => $formattedSignatureProperties,
            'file' => $pdfVisibleWithImageTtd
        ];

        $client = new Client();

        try {
            $apiUrl = rtrim($reqBodyUrl, '/') . '/api/v2/sign/pdf';
            $apiResponse = $client->post($apiUrl, [
                'json' => $requestData,
                'auth' => [$username, $password],
            ]);
            $statusCode = $apiResponse->getStatusCode();
            $apiResponseBody = ($statusCode === 200) ? json_encode(["status" => "success"]) : $apiResponse->getBody()->getContents(); 
            $status = ($statusCode === 200) ? "Berhasil" : "Gagal";
            BsreLog::saveLog($apiResponseBody, $namaFormulir, $typeFormulir, $status);
            $response->getBody()->write($apiResponse->getBody()->getContents());
            return $response->withHeader('Content-Type', 'application/json')->withStatus($apiResponse->getStatusCode());
        } catch (\Exception $e) {
            $status = "Gagal";
            $log = new Logger('api-error');
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/api_error.log', Logger::ERROR));

            $apiResponseMessage = 'Terjadi Kesalahan Pada Server BSRE';
            if ($e instanceof ClientException || $e instanceof ServerException) {
                $apiResponse = $e->getResponse();
                $statusCode = $apiResponse->getStatusCode();
                if ($statusCode !== 500) {
                    $apiResponseMessage = $apiResponse->getBody()->getContents();
                }
            }
            $log->error('API Error:', [
                'error_message' => $apiResponseMessage,
            ]);
            BsreLog::saveLog($apiResponseMessage, $namaFormulir, $typeFormulir, $status);
            
            $response->getBody()->write($apiResponseMessage);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);

        }
    }
}
