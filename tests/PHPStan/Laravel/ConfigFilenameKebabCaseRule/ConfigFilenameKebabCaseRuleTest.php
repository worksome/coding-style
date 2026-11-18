<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\ConfigFilenameKebabCaseRule;

use Worksome\CodingStyle\PHPStan\Laravel\ConfigFilenameKebabCaseRule;

it('requires config files to be kebab-case', function (string $path, array ...$errors) {
    $this->rule = new ConfigFilenameKebabCaseRule(__DIR__ . '/Fixture');

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'kebab-case config' => [
        __DIR__ . '/Fixture/config/kebab-case.php',
    ],
    'nested kebab-case config' => [
        __DIR__ . '/Fixture/config/nested/also-kebab.php',
    ],
    'camelCase config' => [
        __DIR__ . '/Fixture/config/camelCase.php',
        ['Config files should be named with kebab-case.', 1],
    ],
    'snake_case config' => [
        __DIR__ . '/Fixture/config/snake_case.php',
        ['Config files should be named with kebab-case.', 1],
    ],
    'config with a dotted name' => [
        __DIR__ . '/Fixture/config/mail.localSettings.php',
        ['Config files should be named with kebab-case.', 1],
    ],
    'directory ending in config' => [
        __DIR__ . '/Fixture/app/reconfig/mailSettings.php',
    ],
    'non-config file' => [
        __DIR__ . '/Fixture/notConfig.php',
    ],
]);

it('ignores `config` directories above the project root', function () {
    $this->rule = new ConfigFilenameKebabCaseRule(__DIR__ . '/Fixture/config/project');

    expect(__DIR__ . '/Fixture/config/project/app/UserProfile.php')->toHaveRuleErrors([]);
});
