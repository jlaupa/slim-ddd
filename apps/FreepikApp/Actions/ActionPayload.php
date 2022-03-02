<?php

declare(strict_types=1);

namespace FreepikApp\Actions;

use JsonSerializable;

class ActionPayload implements JsonSerializable
{
    public function __construct(
        private int $statusCode = 200,
        private array|object|null $data = null,
        private ?ActionError $error = null
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): array|null|object
    {
        return $this->data;
    }

    public function getError(): ?ActionError
    {
        return $this->error;
    }

    public function jsonSerialize(): array|null|ActionError
    {
        $payload = null;

        if (null !== $this->data) {
            $payload = $this->data;
        } elseif (null !== $this->error) {
            $payload = $this->error;
        }

        return $payload;
    }
}
