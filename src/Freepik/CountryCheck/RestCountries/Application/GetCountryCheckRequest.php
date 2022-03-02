<?php

declare(strict_types=1);

namespace App\Freepik\CountryCheck\RestCountries\Application;

use App\Freepik\CountryCheck\RestCountries\Domain\ExecuteAlphaRequest;
use App\Freepik\CountryCheck\RestCountries\Domain\HttpRepositoryInterface;
use App\Freepik\CountryCheck\Shared\Domain\AlphaResponse;

class GetCountryCheckRequest
{
    public function __construct(private HttpRepositoryInterface $repository)
    {
    }

    public function execute(string $countryCode): AlphaResponse
    {
        $request = new ExecuteAlphaRequest($countryCode);

        return $this->repository->getCountry($request);
    }
}
