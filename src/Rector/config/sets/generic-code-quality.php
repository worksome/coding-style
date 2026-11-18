<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\Config\RectorConfig;
use Worksome\CodingStyle\Rector\Generic\DisallowedAttributesRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig
        ->ruleWithConfiguration(DisallowedAttributesRector::class, [
            'JetBrains\PhpStorm\Pure',
        ]);

    $rectorConfig->rule(CompactToVariablesRector::class);
};
