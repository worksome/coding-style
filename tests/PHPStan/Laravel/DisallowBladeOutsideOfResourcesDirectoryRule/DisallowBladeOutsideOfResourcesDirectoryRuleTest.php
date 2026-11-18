<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\DisallowBladeOutsideOfResourcesDirectoryRule;

use Worksome\CodingStyle\PHPStan\Laravel\DisallowBladeOutsideOfResourcesDirectoryRule;

it('disallows Blade files outside of the resources directory', function (string $path, array ...$errors) {
    $this->rule = new DisallowBladeOutsideOfResourcesDirectoryRule(__DIR__ . '/Fixture/resources', __DIR__);

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'Blade file outside resources' => [
        __DIR__ . '/Fixture/invalid.blade.php',
        ['Blade files must be placed in the resources directory.', 1],
    ],
    'Blade file in resources' => [
        __DIR__ . '/Fixture/resources/valid.blade.php',
    ],
    'Blade file nested in resources' => [
        __DIR__ . '/Fixture/resources/nested/valid.blade.php',
    ],
    'Blade file in a similarly named directory' => [
        __DIR__ . '/Fixture/resources-old/sibling.blade.php',
        ['Blade files must be placed in the resources directory.', 1],
    ],
    'non-Blade file' => [
        __DIR__ . '/Fixture/not_a_blade_file.php.inc',
    ],
]);

it('normalises the configured resources directory', function () {
    $this->rule = new DisallowBladeOutsideOfResourcesDirectoryRule(
        str_replace('/', '\\', __DIR__ . '/Fixture/resources/'),
        __DIR__,
    );

    expect(__DIR__ . '/Fixture/resources/valid.blade.php')->toHaveRuleErrors([]);
});

it('resolves a relative resources directory', function (string $resourcesDirectory) {
    $this->rule = new DisallowBladeOutsideOfResourcesDirectoryRule($resourcesDirectory, __DIR__ . '/Fixture');

    expect(__DIR__ . '/Fixture/resources/valid.blade.php')->toHaveRuleErrors([])
        ->and(__DIR__ . '/Fixture/invalid.blade.php')->toHaveRuleErrors([
            ['Blade files must be placed in the resources directory.', 1],
        ]);
})->with(['resources', './resources', 'resources-old/../resources', __DIR__ . '/Fixture/resources-old/../resources']);

it('resolves a resources directory above the working directory', function () {
    $this->rule = new DisallowBladeOutsideOfResourcesDirectoryRule('../resources', __DIR__ . '/Fixture/app');

    expect(__DIR__ . '/Fixture/resources/valid.blade.php')->toHaveRuleErrors([])
        ->and(__DIR__ . '/Fixture/invalid.blade.php')->toHaveRuleErrors([
            ['Blade files must be placed in the resources directory.', 1],
        ]);
});
