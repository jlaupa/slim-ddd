<?php

declare(strict_types=1);

namespace App\Shared\Domain;

class SharedRequest extends DomainEntity
{
    public function jsonSerialize(): array
    {
        return [
        ];
    }
}
