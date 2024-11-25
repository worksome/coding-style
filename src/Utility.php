<?php

declare(strict_types=1);

namespace Worksome\CodingStyle;

use RuntimeException;

class Utility
{
    public static function preg_match(
        string $pattern,
        string $subject,
        iterable|null &$matches = null,
        int $flags = 0,
        int $offset = 0,
    ): int {
        error_clear_last();

        $safeResult = preg_match($pattern, $subject, $matches, $flags, $offset);

        if ($safeResult === false) {
            throw self::getPcreException();
        }

        return $safeResult;
    }

    private static function getPcreException(): RuntimeException
    {
        return new RuntimeException(match ($lastError = preg_last_error()) {
            PREG_INTERNAL_ERROR => 'PREG_INTERNAL_ERROR: Internal error',
            PREG_BACKTRACK_LIMIT_ERROR => 'PREG_BACKTRACK_LIMIT_ERROR: Backtrack limit reached',
            PREG_RECURSION_LIMIT_ERROR => 'PREG_RECURSION_LIMIT_ERROR: Recursion limit reached',
            PREG_BAD_UTF8_ERROR => 'PREG_BAD_UTF8_ERROR: Invalid UTF8 character',
            PREG_BAD_UTF8_OFFSET_ERROR => 'PREG_BAD_UTF8_OFFSET_ERROR',
            PREG_JIT_STACKLIMIT_ERROR => 'PREG_JIT_STACKLIMIT_ERROR',
            default =>  'Unknown PCRE error: ' . $lastError,
        }, $lastError);
    }
}
