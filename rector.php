<?php

declare(strict_types=1);

use Worksome\CodingStyle\WorksomeRectorConfig;

return WorksomeRectorConfig::configure(larastan: false)
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
