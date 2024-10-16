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
    'valid migration with Schema::create' => [
        __DIR__ . '/Fixture/database/migrations/valid_migration_with_schema_create.php.inc',
    ],
    'valid migration with DB::update' => [
        __DIR__ . '/Fixture/database/migrations/valid_migration_with_db_update.php.inc',
    ],
    'valid migration with delete method' => [
        __DIR__ . '/Fixture/database/migrations/valid_migration_with_db_update.php.inc',
    ],
    'invalid migration' => [
        __DIR__ . '/Fixture/database/migrations/invalid_migration.php.inc',
        [
            "Line 20: The 'update()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            20,
        ],
        [
            "Line 24: The 'insert()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            24,
        ],
        [
            "Line 29: The 'save()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            29,
        ],
        [
            "Line 32: The 'saveQuietly()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            32,
        ],
        [
            "Line 34: The 'delete()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            34,
        ],
        [
            "Line 37: The 'restore()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            37,
        ],
    ],
    'invalid migration with multiple models' => [
        __DIR__ . '/Fixture/database/migrations/invalid_migration_with_multiple_models.php.inc',
        [
            "Line 21: The 'update()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
            21,
        ],
    ],
]);
