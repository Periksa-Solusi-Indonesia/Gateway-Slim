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
                    'driver'    => $_SERVER['DB_CONNECTION'] ?: 'mysql',
                    'host'      => $_SERVER['DB_HOST'] ?: 'localhost',
                    'database'  => $_SERVER['DB_DATABASE'] ?: 'slim_db',
                    'username'  => $_SERVER['DB_USERNAME'] ?: 'root',
                    'password'  => $_SERVER['DB_PASSWORD'] ?: '',
                    'charset'   => $_SERVER['DB_CHARSET'] ?: 'utf8',
                    'collation' => $_SERVER['DB_COLLATION'] ?: 'utf8_unicode_ci',
                    'prefix'    => $_SERVER['DB_PREFIX'] ?: '',
                ]
            ]);
        }
    ]);
};
