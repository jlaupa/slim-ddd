<?php

declare(strict_types=1);

namespace App\Freepik\CountryCheck\RestCountries\Domain;

use App\Freepik\CountryCheck\Shared\Domain\AlphaRequest;
use App\Freepik\CountryCheck\Shared\Domain\AlphaResponse;

interface HttpRepositoryInterface
{
    public function getCountry(AlphaRequest $request): AlphaResponse;
}
