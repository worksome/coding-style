<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Worksome\CodingStyle\Rector\Generic\DisallowedAttributesRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig
        ->ruleWithConfiguration(DisallowedAttributesRector::class, [
            'JetBrains\PhpStorm\Pure',
        ]);
};
