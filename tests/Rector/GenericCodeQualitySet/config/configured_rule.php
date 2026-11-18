<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Worksome\CodingStyle\Rector\WorksomeSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([WorksomeSetList::GENERIC_CODE_QUALITY]);
};
