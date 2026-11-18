<?php

namespace Worksome\CodingStyle\Tests\PHPStan\PascalCaseEnumCasesRule;

use Worksome\CodingStyle\PHPStan\PascalCaseEnumCasesRule;

it('requires PascalCase enum cases', function (string $path, array ...$errors) {
    $this->rule = new PascalCaseEnumCasesRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'not PascalCase' => [
        __DIR__ . '/Fixture/not_pascal_cased.php.inc',
        ['Enum case [thirty_four] must be PascalCase.', 10],
    ],
    'not PascalCase backed' => [
        __DIR__ . '/Fixture/not_pascal_cased_backed.php.inc',
        ['Enum case [thirty_four] must be PascalCase.', 10],
    ],
    'not PascalCase with an attribute' => [
        __DIR__ . '/Fixture/not_pascal_cased_with_attribute.php.inc',
        ['Enum case [not_pascal] must be PascalCase.', 8],
    ],
    'PascalCase' => [
        __DIR__ . '/Fixture/skip_pascal_cased.php.inc',
    ],
]);
