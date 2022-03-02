<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use FreepikApp\Settings\Settings;
use FreepikApp\Settings\SettingsInterface;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true,
                'logError' => true,
                'logErrorDetails' => true,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => 'php://stdout',
                    'level' => Logger::DEBUG,
                ],
            ]);
        },
    ]);
};
