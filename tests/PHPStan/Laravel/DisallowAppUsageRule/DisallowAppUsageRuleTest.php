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
    'calls resolve helper with parameters' => [
        __DIR__ . '/Fixture/resolve_helper_with_parameters.php.inc',
        [
            'Usage of resolve helper is disallowed. Use dependency injection instead.',
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
    'skips app function from other namespace' => [
        __DIR__ . '/Fixture/skip_app_function_in_namespace.php.inc',
    ],
    'skips resolve function from other namespace' => [
        __DIR__ . '/Fixture/skip_resolve_function_in_namespace.php.inc',
    ],
    'skips function call on variable' => [
        __DIR__ . '/Fixture/skip_variable_call.php.inc',
    ],
    'calls app helper when inside a namespace' => [
        __DIR__ . '/Fixture/app_helper_in_namespace.php.inc',
        [
            'Usage of app helper is disallowed. Use dependency injection instead.',
            9,
        ],
    ],
    'calls resolve helper when inside a namespace' => [
        __DIR__ . '/Fixture/resolve_helper_in_namespace.php.inc',
        [
            'Usage of resolve helper is disallowed. Use dependency injection instead.',
            9,
        ],
    ],
    'calls app helper with chain calls after' => [
        __DIR__ . '/Fixture/app_helper_with_chain_calls.php.inc',
        [
            'Usage of app helper is disallowed. Use dependency injection instead.',
            9,
        ],
    ],
    'calls resolve helper with chain calls after' => [
        __DIR__ . '/Fixture/resolve_helper_with_chain_calls.php.inc',
        [
            'Usage of resolve helper is disallowed. Use dependency injection instead.',
            9,
        ],
    ],
]);
