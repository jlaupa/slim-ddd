<?php

declare(strict_types=1);

use FreepikApp\Handlers\HttpErrorHandler;
use FreepikApp\Handlers\ShutdownHandler;
use FreepikApp\ResponseEmitter\ResponseEmitter;
use FreepikApp\Settings\SettingsInterface;
use Slim\App;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Interfaces\CallableResolverInterface;

require __DIR__.'/../../../apps/FreepikApp/Core/bootstrap.php';

/** @var App $app */
$middleware = require __DIR__.'/../../../apps/FreepikApp/Core/middleware.php';
$middleware($app);

$routes = require __DIR__.'/../../../apps/FreepikApp/Core/routes.php';
$routes($app);

/** @var \DI\Container $container */
/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$responseFactory = $app->getResponseFactory();
/** @var CallableResolverInterface $callableResolver */
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
