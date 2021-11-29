<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\DisallowAppUsageRule;

use Worksome\CodingStyle\PHPStan\Laravel\DisallowAppHelperUsageRule;

it('checks app helper rule', function (string $path, array ...$errors) {
    $this->rule = new DisallowAppHelperUsageRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'calls app helper with args' => [
        __DIR__ . '/Fixture/app_helper_with_arg.php.inc',
        [
            'Usage of app helper is disallowed. Use dependency injection instead.',
            7,
        ],
    ],
    'calls app helper without args' => [
        __DIR__ . '/Fixture/app_helper_without_arg.php.inc',
        [
            'Usage of app helper is disallowed. Use dependency injection instead.',
            7,
        ],
    ],
    'calls app function from other namespace' => [
        __DIR__ . '/Fixture/skip_app_function_in_namespace.php.inc',
    ]
]);
