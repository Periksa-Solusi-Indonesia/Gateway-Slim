<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Controllers\UserController;
use App\Controllers\SignController;
use App\Controllers\VerifyController;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
    $app->group('/api/user', function (Group $group) {
        $group->post('/register', [UserController::class, 'registerUser']);
        $group->post('/check/status', [UserController::class, 'checkStatusByNik']);
        $group->get('/certificate/chain/{id}', [UserController::class, 'getCertificateChainByNik']);
    });
    $app->group('/api/sign', function (Group $group) {
        $group->post('/get/totp', [SignController::class, 'requestOtpByNik']);
        $group->post('/pdf', [SignController::class, 'signPdfByNik']);
    });
    $app->group('/api/verify', function (Group $group) {
        $group->post('/pdf', [VerifyController::class, 'verifyPdf']);
    });
};
