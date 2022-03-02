<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Throwable;

class ParamsAreMissingException extends HttpBadRequestException
{
    public function __construct(ServerRequestInterface $request, ?string $atrribute = null, ?Throwable $previous = null)
    {
        $message = "Params are missing {$atrribute}";
        parent::__construct($request, $message, $previous);
    }
}
