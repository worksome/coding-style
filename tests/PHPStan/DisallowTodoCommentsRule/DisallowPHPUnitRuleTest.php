<?php

namespace Worksome\CodingStyle\Tests\PHPStan\DisallowTodoCommentsRule;

use Worksome\CodingStyle\PHPStan\DisallowTodoCommentsRule;

it('checks for declaration of strict types', function (string $path, array ...$errors) {
    $this->rule = new DisallowTodoCommentsRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'without TODO comment' => [
        __DIR__ . '/Fixture/fixture.php.excluding',
    ],
    'with in-line TODO comment' => [
        __DIR__ . '/Fixture/fixture.php.inline',
        [
            'Comments with TODO are disallowed.',
            5,
        ],
    ],
    'with PhpDoc TODO comment' => [
        __DIR__ . '/Fixture/fixture.php.phpdoc',
        [
            'Comments with TODO are disallowed.',
            5,
        ],
    ],
    'with TODO comment' => [
        __DIR__ . '/Fixture/fixture.php.no-class',
        [
            'Comments with TODO are disallowed.',
            3,
        ],
    ],
]);
