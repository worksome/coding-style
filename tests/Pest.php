<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Worksome\CodingStyle\Tests\PhpCsFixer\BasePhpCsFixerTestCase;
use Worksome\CodingStyle\Tests\PHPStan\BaseRuleTestCase;
use Worksome\CodingStyle\Tests\Rector\BaseRectorTestCase;

uses(BasePhpCsFixerTestCase::class)->in('PhpCsFixer');
uses(BaseRuleTestCase::class)->in('PHPStan');
uses(BaseRectorTestCase::class)->in('Rector');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toHaveRuleErrors', function (array $errors) {
    test()->analyse(
        [
            $this->value
        ],
        $errors,
    );
});
