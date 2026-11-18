<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\DisallowBladeOutsideOfResourcesDirectoryRule;

use Worksome\CodingStyle\PHPStan\Laravel\DisallowBladeOutsideOfResourcesDirectoryRule;

it('disallows Blade files outside of the resources directory', function (string $path, array ...$errors) {
    $this->rule = new DisallowBladeOutsideOfResourcesDirectoryRule(__DIR__ . '/Fixture/resources');

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
    );

    expect(__DIR__ . '/Fixture/resources/valid.blade.php')->toHaveRuleErrors([]);
});
