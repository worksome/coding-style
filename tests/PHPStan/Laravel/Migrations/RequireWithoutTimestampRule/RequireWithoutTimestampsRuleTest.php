<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule;

use Worksome\CodingStyle\PHPStan\Laravel\Migrations\RequireWithoutTimestampsRule;

it('checks withoutTimestamps in migration rule', function (string $path, array ...$errors) {
    $this->rule = new RequireWithoutTimestampsRule($path);


    expect($path)->toHaveRuleErrors($errors);
})->with([
    'valid migration' => [
        __DIR__ . '/Fixture/database/migrations/valid_migration.php.inc',
    ],
    'invalid migration' => [
        __DIR__ . '/Fixture/database/migrations/invalid_migration.php.inc',
        [
            "Line 19: The 'update()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            19,
        ],
    ],
    'invalid migration with multiple models' => [
        __DIR__ . '/Fixture/database/migrations/invalid_migration.php.inc',
        [
            "Line 19: The 'update()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            19,
        ],
    ],
]);
