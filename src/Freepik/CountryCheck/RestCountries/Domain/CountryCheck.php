<?php

declare(strict_types=1);

namespace App\Freepik\CountryCheck\RestCountries\Domain;

use App\Shared\Domain\DomainEntity;

class CountryCheck extends DomainEntity
{
    public function __construct(
        private bool $code,
        private bool $region,
        private bool $population,
        private bool $rival
    ) {
    }

    public function isCode(): bool
    {
        return $this->code;
    }

    public function isRegion(): bool
    {
        return $this->region;
    }

    public function isPopulation(): bool
    {
        return $this->population;
    }

    public function isRival(): bool
    {
        return $this->rival;
    }

    public function jsonSerialize(): array
    {
        return [
            'result' => $this->isResult(),
            'criteria' => [
                'code' => $this->isCode(),
                'region' => $this->isRegion(),
                'population' => $this->isPopulation(),
                'rival' => $this->isRival(),
            ],
        ];
    }

    public function isResult(): bool
    {
        return $this->isCode() && $this->isRegion() && $this->isPopulation() && $this->isRival();
    }
}
