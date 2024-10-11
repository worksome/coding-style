<?php

declare(strict_types=1);

use Worksome\CodingStyle\PHPStan\Laravel\DisallowEnvironmentCheck\DisallowEnvironmentCheckRule;

it('checks for environment checks made using the app helper', function () {
    $this->rule = new DisallowEnvironmentCheckRule();

    $errors = array_map(fn (int $lineNumber) => [
        'Environment checks are disallowed. Please use the driver pattern instead.',
        $lineNumber,
    ], [4, 5, 6]);

    expect(__DIR__ . '/Fixture/app_helper_environment_checks.php.inc')->toHaveRuleErrors($errors);
});

it('checks for environment checks made using the app facade', function () {
    $this->rule = new DisallowEnvironmentCheckRule();

    $errors = array_map(fn (int $lineNumber) => [
        'Environment checks are disallowed. Please use the driver pattern instead.',
        $lineNumber,
    ], [4, 5, 6, 9, 10, 11]);

    expect(__DIR__ . '/Fixture/app_facade_environment_checks.php.inc')->toHaveRuleErrors($errors);
});

it('checks for environment checks made using an imported app facade', function () {
    $this->rule = new DisallowEnvironmentCheckRule();

    $errors = array_map(fn (int $lineNumber) => [
        'Environment checks are disallowed. Please use the driver pattern instead.',
        $lineNumber,
    ], [6, 7, 8]);

    expect(__DIR__ . '/Fixture/imported_app_facade_environment_checks.php.inc')->toHaveRuleErrors($errors);
});

it('checks for environment checks made using the application contract', function () {
    $this->rule = new DisallowEnvironmentCheckRule();

    $errors = array_map(fn (int $lineNumber) => [
        'Environment checks are disallowed. Please use the driver pattern instead.',
        $lineNumber,
    ], [6, 10]);

    expect(__DIR__ . '/Fixture/application_class_environment_checks.php.inc')->toHaveRuleErrors($errors);
});
