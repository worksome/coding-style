<?php

namespace Worksome\CodingStyle\Rector;

use Rector\Set\Contract\SetListInterface;

class WorksomeSetList implements SetListInterface
{
    public const LARAVEL_CODE_QUALITY = __DIR__ . '/config/sets/laravel-code-quality.php';

    public const GENERIC_CODE_QUALITY = __DIR__ . '/config/sets/generic-code-quality.php';
}
