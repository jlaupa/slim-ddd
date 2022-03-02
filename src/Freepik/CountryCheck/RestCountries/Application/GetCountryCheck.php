<?php

declare(strict_types=1);

namespace App\Freepik\CountryCheck\RestCountries\Application;

use App\Freepik\CountryCheck\RestCountries\Domain\CountryCheck;
use App\Freepik\CountryCheck\RestCountries\Domain\Region;

class GetCountryCheck
{
    public const COUNTRY_CODE_NORUEGA = 'NO';

    public function __construct(private GetCountryCheckRequest $countryCheckRequest)
    {
    }

    public function execute(string $countryCode): CountryCheck
    {
        $country = $this->countryCheckRequest->execute($countryCode);

        //TODO: Business rules
        $code = $this->isVowel($countryCode);
        $region = $this->isEurope($country->getRegion());
        $population = $this->isPopulation(
            $country->getRegion(),
            $country->getPopulation()
        );
        $rival = $this->isRival($country->getPopulation());
        //End Business rules

        return new CountryCheck(
            $code,
            $region,
            $population,
            $rival
        );
    }

    public function isVowel(string $countryCode): bool
    {
        $letter = mb_substr($countryCode, 0, 1);
        $vowels = ['a', 'e', 'i', 'o', 'u'];

        return in_array(strtolower($letter), $vowels);
    }

    public function isEurope(string $region): bool
    {
        return Region::EUROPE === $region;
    }

    public function isPopulation(string $region, int $population): bool
    {
        $isPopulation = false;

        if (Region::ASIA !== $region && $population >= 50000000) {
            $isPopulation = true;
        }

        if (!$isPopulation && $population >= 8000000) {
            $isPopulation = true;
        }

        return $isPopulation;
    }

    public function isRival(int $population): bool
    {
        $country = $this->countryCheckRequest->execute(
            self::COUNTRY_CODE_NORUEGA
        );

        return $population >= $country->getPopulation();
    }
}
