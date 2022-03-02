<?php

declare(strict_types=1);

namespace App\Tests\Freepik\CountryCheck\Application;

use App\Freepik\CountryCheck\RestCountries\Application\GetCountryCheck;
use App\Freepik\CountryCheck\RestCountries\Application\GetCountryCheckRequest;
use App\Freepik\CountryCheck\RestCountries\Infrastructure\HttpRepository;
use App\Tests\TestCase;

class GetCountryCheckTest extends TestCase
{
    public function countryCheckProvider(): array
    {
        //$countryPostal, $isVowel, $isEurope, $isPopulation, $isRival, $result
        return [
            ['ES', true, true, true, true, true],
            ['AR', true, false, true, true, false],
            ['NO', false, true, false, true, false],
            ['RU', false, true, true, true, false],
            ['UKR', true, true, true, true, true],
            ['CHN', false, false, true, true, false],
        ];
    }

    /**
     * @dataProvider countryCheckProvider
     */
    public function test_get_country_check_execute(
        string $countryPostal,
        bool $isVowel,
        bool $isEurope,
        bool $isPopulation,
        bool $isRival,
        bool $result
    ): void {
        $repository = new HttpRepository();
        $countryCheckRequest = new GetCountryCheckRequest($repository);
        $getCountryCheck = new GetCountryCheck($countryCheckRequest);

        $country = $getCountryCheck->execute($countryPostal);

        $this->assertEquals($isVowel, $country->isCode());
        $this->assertEquals($isEurope, $country->isRegion());
        $this->assertEquals($isPopulation, $country->isPopulation());
        $this->assertEquals($isRival, $country->isRival());
        $this->assertEquals($result, $country->isResult());
    }
}
