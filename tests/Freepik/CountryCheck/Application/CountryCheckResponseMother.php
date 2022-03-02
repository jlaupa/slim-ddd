<?php

declare(strict_types=1);

namespace App\Tests\Freepik\CountryCheck\Application;

use App\Freepik\CountryCheck\RestCountries\Domain\CountryCheck;

final class CountryCheckResponseMother
{
    public static function create(
        bool $code = true,
        bool $region = true,
        bool $population = true,
        bool $rival = true
    ): array {
        $countryCheckResponse = new CountryCheck(
            $code,
            $region,
            $population,
            $rival
        );

        return $countryCheckResponse->jsonSerialize();
    }
}
