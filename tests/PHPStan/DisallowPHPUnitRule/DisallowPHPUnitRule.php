<?php

namespace Worksome\CodingStyle\Tests\PHPStan\DeclareStrictTypesRule;

use Worksome\CodingStyle\PHPStan\DisallowPHPUnitRule;

it('checks for declaration of strict types', function (string $path, array ...$errors) {
    $this->rule = new DisallowPHPUnitRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'PHPUnit test' => [
        __DIR__ . '/Fixture/PHPUnitTest.php',
        [
            'PHPUnit tests are not allowed. Please use Pest PHP instead. If this is a TestCase, make it abstract to pass validation.',
            5,
        ],
    ],
    'Pest file' => [
        __DIR__ . '/Fixture/PestTest.php',
    ],
    'Abstract PHPUnit test case' => [
        __DIR__ . '/Fixture/TestCase.php',
    ],
    'Generic class' => [
        __DIR__ . '/Fixture/GenericClass.php',
    ],
]);
