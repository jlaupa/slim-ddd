<?php

declare(strict_types=1);

use App\Freepik\CountryCheck\RestCountries\Domain\HttpRepositoryInterface;
use App\Freepik\CountryCheck\RestCountries\Infrastructure\HttpRepository;
use function DI\autowire;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        HttpRepositoryInterface::class => autowire(HttpRepository::class),
    ]);
};
