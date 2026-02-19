<?php

namespace Worksome\CodingStyle\Tests\PHPStan\DeclareStrictTypesRule;

use Worksome\CodingStyle\PHPStan\DeclareStrictTypesRule;

it('checks for declaration of strict types', function (string $path, array ...$errors) {
    $this->rule = new DeclareStrictTypesRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'missing strict types' => [
        __DIR__ . '/Fixture/fixture.php.excluding',
        [
            'PHP files should declare strict types.',
            3,
        ],
    ],
    'file with strict types' => [
        __DIR__ . '/Fixture/fixture.php.including',
    ],
]);
