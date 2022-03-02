<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final class Utils
{
    public static function isJSON(string $string): bool
    {
        return is_array(json_decode($string, true));
    }
}
