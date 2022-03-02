<?php

declare(strict_types=1);

namespace App\Freepik\CountryCheck\RestCountries\Infrastructure;

use App\Freepik\CountryCheck\RestCountries\Domain\ExecuteAlphaRequest;
use App\Freepik\CountryCheck\RestCountries\Domain\ExecuteAlphaResponse;
use App\Freepik\CountryCheck\RestCountries\Domain\HttpRepositoryInterface;
use App\Freepik\CountryCheck\RestCountries\Infrastructure\Exceptions\GetCountryException;
use App\Freepik\CountryCheck\Shared\Domain\AlphaRequest;
use App\Freepik\CountryCheck\Shared\Domain\AlphaResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class HttpRepository implements HttpRepositoryInterface
{
    private Client $http;

    public function __construct()
    {
        $this->loadConfig();
    }

    public function getCountry(AlphaRequest $request): AlphaResponse
    {
        try {
            //Pending: implement memcached for 12 hours.
            $apiResponse = $this->http->request(
                ExecuteAlphaRequest::METHOD,
                ExecuteAlphaRequest::ENDPOINT,
                ['query' => $request->jsonSerialize()],
            );

            $response = new ExecuteAlphaResponse(
                $apiResponse->getBody()->getContents(),
                $apiResponse->getStatusCode(),
                $apiResponse->getHeaders()
            );
        } catch (ClientException $clientException) {
            $apiResponse = $clientException->getResponse();

            throw new GetCountryException(
                $apiResponse->getBody()->getContents(),
                $apiResponse->getStatusCode()
            );
        }

        return $response;
    }

    public function loadConfig()
    {
        $this->http = new Client(['base_uri' => $_ENV['API_REST_COUNTRIES']]);
    }
}
