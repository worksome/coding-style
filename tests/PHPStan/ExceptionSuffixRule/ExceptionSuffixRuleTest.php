<?php

namespace Worksome\CodingStyle\Tests\PHPStan\ExceptionSuffixRule;

use Worksome\CodingStyle\PHPStan\ExceptionSuffixRule;

it('checks exceptions have the `Exception` suffix', function (string $path, array ...$errors) {
    $this->rule = new ExceptionSuffixRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'correctly suffixed exception' => [
        __DIR__ . '/Fixture/correct_exception.php.inc',
    ],
    'exception without suffix' => [
        __DIR__ . '/Fixture/wrong_exception_name.php.inc',
        ['Exceptions should have `Exception` suffix.', 7],
    ],
    'indirect exception without suffix' => [
        __DIR__ . '/Fixture/wrong_exception_name_indirect.php.inc',
        ['Exceptions should have `Exception` suffix.', 5],
    ],
    'error without suffix' => [
        __DIR__ . '/Fixture/wrong_error_name.php.inc',
        ['Exceptions should have `Exception` suffix.', 5],
    ],
    'non-exception class' => [
        __DIR__ . '/Fixture/skip_non_exception.php.inc',
    ],
    'throwable interface' => [
        __DIR__ . '/Fixture/skip_interface.php.inc',
    ],
]);
