<?php

declare(strict_types=1);

namespace FreepikApp\Actions\CountryCheck;

use App\Freepik\CountryCheck\RestCountries\Application\GetCountryCheck;
use FreepikApp\Actions\Action;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class CountryCheckAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        private GetCountryCheck $getCountryCheck
    ) {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $countryCode = $this->resolveQueryParam('country-code');
        $getCountryCheck = $this->getCountryCheck->execute($countryCode);
        $countryCheck = $getCountryCheck->jsonSerialize();

        return $this->respondWithData($countryCheck);
    }
}
