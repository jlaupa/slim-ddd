<?php

declare(strict_types=1);

namespace App\Tests\Freepik\CountryCheck\Domain;

use App\Freepik\CountryCheck\RestCountries\Domain\CountryCheck;
use App\Tests\TestCase;

class CountryCheckTest extends TestCase
{
    public function countryCheckProvider(): array
    {
        //$code, $region, $population, $rival, $result
        return [
            [false, true, true, true, false],
            [true, false, true, true, false],
            [true, true, false, true, false],
            [true, true, true, false, false],
            [true, true, true, true, true],
        ];
    }

    /**
     * @dataProvider countryCheckProvider
     */
    public function test_getters(bool $code, bool $region, bool $population, bool $rival, bool $result)
    {
        $countryCheck = new CountryCheck($code, $region, $population, $rival);

        $this->assertEquals($code, $countryCheck->isCode());
        $this->assertEquals($region, $countryCheck->isRegion());
        $this->assertEquals($population, $countryCheck->isPopulation());
        $this->assertEquals($rival, $countryCheck->isRival());
        $this->assertEquals($result, $countryCheck->isResult());
    }

    /**
     * @dataProvider countryCheckProvider
     */
    public function test_json_serialize(bool $code, bool $region, bool $population, bool $rival, bool $result)
    {
        $countryCheck = new CountryCheck($code, $region, $population, $rival);

        $expectedPayload = [
            'result' => $result,
            'criteria' => [
                'code' => $code,
                'region' => $region,
                'population' => $population,
                'rival' => $rival,
            ],
        ];

        $this->assertEquals($expectedPayload, $countryCheck->jsonSerialize());
    }
}
