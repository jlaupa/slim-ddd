<?php

declare(strict_types=1);

namespace App\Tests;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

class TestCase extends PHPUnit_TestCase
{
    use ProphecyTrait;

    protected function getAppInstance(): App
    {
        $containerBuilder = new ContainerBuilder();

        $settings = require __DIR__.'/../apps/FreepikApp/Core/settings.php';
        $settings($containerBuilder);

        $dependencies = require __DIR__.'/../apps/FreepikApp/Core/dependencies.php';
        $dependencies($containerBuilder);

        $repositories = require __DIR__.'/../apps/FreepikApp/Core/repositories.php';
        $repositories($containerBuilder);

        $container = $containerBuilder->build();

        AppFactory::setContainer($container);
        $app = AppFactory::create();

        $middleware = require __DIR__.'/../apps/FreepikApp/Core/middleware.php';
        $middleware($app);

        $routes = require __DIR__.'/../apps/FreepikApp/Core/routes.php';
        $routes($app);

        return $app;
    }

    protected function createRequest(
        string $method,
        string $path,
        ?array $queryParams = [],
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $cookies = [],
        array $serverParams = []
    ): Request {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        $SlimRequest = new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);

        return $SlimRequest->withQueryParams($queryParams);
    }
}
