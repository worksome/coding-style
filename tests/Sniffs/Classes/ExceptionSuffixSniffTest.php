<?php

namespace Worksome\CodingStyle\Tests\Sniffs\Classes;

use Worksome\CodingStyle\Sniffs\Classes\ExceptionSuffixSniff;

beforeEach(function () {
    $this->sniff = ExceptionSuffixSniff::class;
});

it('has no errors', function (string $path) {
    $report = checkFile($path);

    expect($report)->toHaveNoSniffErrors();
})->with([
    'Exception with prefix' => __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/CorrectException.php',
    'FQCN with prefix' => __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/FullyQualifiedException.php',
    'random class' => __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/RandomClass.php',
    'interface named exception' => __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/NonExceptionWithInterface.php',
]);

it('has errors', function (string $path, int $line) {
    $report = checkFile($path);

    expect($report)
        ->toHaveSniffErrors(1)
        ->toHaveSniffError(line: $line);
})->with([
    'exception without prefix' => [
        __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/WrongExceptionName.php',
        7,
    ],
    'FQCN without prefix' => [
        __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/WrongExceptionNameWithFullyQualified.php',
        5,
    ],
    'no prefix with interface' => [
        __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/WrongExceptionNameWithInterface.php',
        8,
    ],
    'extending custom exception FQCN' => [
        __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/WrongExceptionNameWithCustomFullyQualified.php',
        5,
    ],
    'one liner class' => [
        __DIR__ . '/../../../testResources/Sniffs/Classes/ExceptionSuffixSniff/WrongExceptionNameOneLinerClass.php',
        5,
    ]
]);
