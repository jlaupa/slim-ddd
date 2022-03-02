<?php

declare(strict_types=1);

namespace App\Freepik\CountryCheck\RestCountries\Domain;

use App\Freepik\CountryCheck\Shared\Domain\AlphaRequest as DomainAlphaRequest;

class ExecuteAlphaRequest extends DomainAlphaRequest
{
    public const ENDPOINT = '/v3.1/alpha/';
    public const METHOD = 'GET';

    public function __construct(private string $countryCode)
    {
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function jsonSerialize(): array
    {
        return [
            'codes' => $this->getCountryCode(),
        ];
    }
}
