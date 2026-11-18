<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\ConfigFilenameKebabCaseRule;

use Worksome\CodingStyle\PHPStan\Laravel\ConfigFilenameKebabCaseRule;

it('requires config files to be kebab-case', function (string $path, array ...$errors) {
    $this->rule = new ConfigFilenameKebabCaseRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'kebab-case config' => [
        __DIR__ . '/Fixture/config/kebab-case.php.inc',
    ],
    'camelCase config' => [
        __DIR__ . '/Fixture/config/camelCase.php.inc',
        ['Config files should be named with kebab-case.', 1],
    ],
    'non-config file' => [
        __DIR__ . '/Fixture/notConfig.php.inc',
    ],
]);
