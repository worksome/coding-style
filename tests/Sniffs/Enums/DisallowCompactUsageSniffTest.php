<?php

namespace Worksome\CodingStyle\Tests\Sniffs\Functions;

use Worksome\CodingStyle\Sniffs\Enums\PascalCasingEnumCasesSniff;

beforeEach(function () {
    $this->sniff = PascalCasingEnumCasesSniff::class;
});

it('has no errors', function (string $path) {
    $report = checkFile($path);

    expect($report)->toHaveNoSniffErrors();
})->with([
    'All pascal cased' => __DIR__ . '/../../../testResources/Sniffs/Enums/PascalCasingEnumCasesSniff/PascalCased.php',
]);

it('has errors', function (string $path, int $line) {
    $report = checkFile($path);

    expect($report)
        ->toHaveSniffErrors(1)
        ->toHaveSniffError(line: $line);
})->with([
    'not all cases pascal casing' => [
        __DIR__ . '/../../../testResources/Sniffs/Enums/PascalCasingEnumCasesSniff/NotPascalCased.php',
        11
    ],
    'not all cases pascal casing with backed enum' => [
        __DIR__ . '/../../../testResources/Sniffs/Enums/PascalCasingEnumCasesSniff/NotPascalCasedBacked.php',
        11
    ],
]);
