<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule;

use Worksome\CodingStyle\PHPStan\Laravel\Migrations\RequireWithoutTimestampsRule;

it('checks withoutTimestamps in migration rule', function (string $path, array ...$errors) {
    $this->rule = new RequireWithoutTimestampsRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'valid migration' => [
        __DIR__ . '/Fixture/database/migrations/valid_migration.php.inc',
    ],
    'invalid migration' => [
        __DIR__ . '/Fixture/database/migrations/invalid_migration.php.inc',
        [
            "invalid_migration file uses 'update' or 'create' action without 'withoutTimestamps()' protection.",
            7,
        ],
    ],
]);
