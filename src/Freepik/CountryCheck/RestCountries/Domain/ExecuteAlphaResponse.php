<?php

declare(strict_types=1);

namespace App\Freepik\CountryCheck\RestCountries\Domain;

use App\Freepik\CountryCheck\Shared\Domain\AlphaResponse as DomainAlphaResponse;

class ExecuteAlphaResponse extends DomainAlphaResponse
{
    private ?string $region;
    private ?int $population;

    public function __construct(string $body, int $statusCode = 200, array $headers = [])
    {
        parent::__construct($body, $statusCode, $headers);

        $alphaResponse = json_decode($body, false, 512, JSON_THROW_ON_ERROR);
        $alphaResponse = end($alphaResponse);

        $this->region = $alphaResponse->region;
        $this->population = $alphaResponse->population;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }
}
