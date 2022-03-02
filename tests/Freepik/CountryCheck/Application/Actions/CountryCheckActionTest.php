<?php

declare(strict_types=1);

namespace App\Tests\Freepik\CountryCheck\Application\Actions;

use App\Freepik\CountryCheck\RestCountries\Domain\ExecuteAlphaResponse;
use App\Freepik\CountryCheck\RestCountries\Domain\HttpRepositoryInterface;
use App\Shared\Domain\Exception\ParamsAreMissingException;
use App\Tests\Freepik\CountryCheck\Application\CountryCheckResponseMother;
use App\Tests\TestCase;
use DI\Container;
use Mockery;

class CountryCheckActionTest extends TestCase
{
    protected function setUp(): void
    {
        $this->app = $this->getAppInstance();

        /** @var Container $container */
        $this->container = $this->app->getContainer();

        $this->repository = Mockery::mock(HttpRepositoryInterface::class);
    }

    /**
     * @throws \JsonException
     */
    public function test_action_ok(): void
    {
        $paramsQuery = ['country-code' => 'ES'];
        $body = '[{
            "region": "Europe",
            "population": 9999999
        }]';

        $alphaResponse = new ExecuteAlphaResponse($body);

        $this->repository->shouldReceive('getCountry')
            ->andReturn($alphaResponse);

        $this->container->set(HttpRepositoryInterface::class, $this->repository);

        $countryCheckResponse = CountryCheckResponseMother::create();
        $request = $this->createRequest(
            'GET',
            '/country-check',
            $paramsQuery
        );

        $response = $this->app->handle($request);
        $payload = (string) $response->getBody();

        $expectedPayload = json_encode($countryCheckResponse, JSON_PRETTY_PRINT);
        $this->assertEquals($expectedPayload, $payload);
    }

    /**
     * @throws \JsonException
     */
    public function test_action_not_ok_by_params_missing(): void
    {
        $this->expectException(ParamsAreMissingException::class);

        $paramsQuery = ['fake' => 'ES'];
        $body = '[{
            "region": "Europe",
            "population": 11111111
        }]';

        $alphaResponse = new ExecuteAlphaResponse($body);

        $this->repository->shouldReceive('getCountry')
            ->andReturn($alphaResponse);

        $this->container->set(HttpRepositoryInterface::class, $this->repository);

        $countryCheckResponse = CountryCheckResponseMother::create();
        $request = $this->createRequest(
            'GET',
            '/country-check',
            $paramsQuery
        );

        $response = $this->app->handle($request);
        $payload = (string) $response->getBody();

        $expectedPayload = json_encode($countryCheckResponse, JSON_PRETTY_PRINT);
        $this->assertEquals($expectedPayload, $payload);
    }
}
