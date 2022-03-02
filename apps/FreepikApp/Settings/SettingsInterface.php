<?php

declare(strict_types=1);

namespace FreepikApp\Settings;

interface SettingsInterface
{
    /**
     * @param string $key
     *
     * @return array<string, mixed>|bool|string
     */
    public function get(string $key = ''): array|string|bool;
}
