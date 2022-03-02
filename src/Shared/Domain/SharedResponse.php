<?php

declare(strict_types=1);

namespace App\Shared\Domain;

class SharedResponse extends DomainEntity
{
    private string $body;
    private int $statusCode;
    private array $headers;

    public function __construct(string $body, int $statusCode = 200, array $headers = [])
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
            'statusCode' => $this->statusCode,
            'headers' => $this->headers,
        ];
    }
}
