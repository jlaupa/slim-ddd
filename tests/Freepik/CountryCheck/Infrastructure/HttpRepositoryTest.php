<?php

declare(strict_types=1);

namespace App\Tests\Freepik\CountryCheck\Infrastructure;

use App\Freepik\CountryCheck\RestCountries\Domain\ExecuteAlphaRequest;
use App\Freepik\CountryCheck\RestCountries\Domain\ExecuteAlphaResponse;
use App\Freepik\CountryCheck\RestCountries\Domain\Region;
use App\Freepik\CountryCheck\RestCountries\Infrastructure\Exceptions\GetCountryException;
use App\Freepik\CountryCheck\RestCountries\Infrastructure\HttpRepository;
use PHPUnit\Framework\TestCase;

class HttpRepositoryTest extends TestCase
{
    public function test_get_country(): void
    {
        $paramsQuery = ['country-code' => 'ES'];

        $alphaRequest = new ExecuteAlphaRequest($paramsQuery['country-code']);

        $httpRepository = new HttpRepository();
        $getCountry = $httpRepository->getCountry($alphaRequest);

        $this->assertInstanceOf(ExecuteAlphaResponse::class, $getCountry);
        $this->assertEquals(Region::EUROPE, $getCountry->getRegion());
    }

    public function test_get_country_not_ok_by_code_invalid(): void
    {
        $this->expectException(GetCountryException::class);

        $paramsQuery = ['country-code' => 'FAKE'];

        $alphaRequest = new ExecuteAlphaRequest($paramsQuery['country-code']);

        $httpRepository = new HttpRepository();
        $httpRepository->getCountry($alphaRequest);
    }
}
