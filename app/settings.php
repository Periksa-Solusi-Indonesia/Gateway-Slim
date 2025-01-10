<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_SERVER['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'driver'    => env('DB_CONNECTION'),
                    'host'      => env('DB_HOST'),
                    'database'  => env('DB_DATABASE'),
                    'username'  => env('DB_USERNAME'),
                    'password'  => env('DB_PASSWORD'),
                    'charset'   => env('DB_CHARSET') ?: 'utf8',
                    'collation' => env('DB_COLLATION') ?: 'utf8_unicode_ci',
                    'prefix'    => env('DB_PREFIX') ?: '',
                ]
            ]);
        }
    ]);
};
