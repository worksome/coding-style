<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Worksome\CodingStyle\WorksomeRectorConfig;

return static function (RectorConfig $rectorConfig) : void {
    WorksomeRectorConfig::setup($rectorConfig);
};
