<?php

namespace Worksome\CodingStyle\Tests\Sniffs\PhpDoc;

use Worksome\CodingStyle\Sniffs\PhpDoc\PropertyDollarSignSniff;

beforeEach(function () {
    $this->sniff = PropertyDollarSignSniff::class;
});

it('has no errors', function (string $path) {
    $report = checkFile($path);

    expect($report)->toHaveNoSniffErrors();
})->with([
    'valid properties' => __DIR__ . '/../../../testResources/Sniffs/PhpDoc/PropertyDollarSignSniff/ValidProperties.php',
]);

it('has errors', function (string $path, array $lines) {
    $report = checkFile($path);

    expect($report)
        ->toHaveSniffErrors(count($lines));

    foreach ($lines as $line) {
        expect($report)
            ->toHaveSniffError(line: $line);
    }
})->with([
    'invalid properties' => [
        __DIR__ . '/../../../testResources/Sniffs/PhpDoc/PropertyDollarSignSniff/InvalidProperties.php',
        [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
    ],
]);

it('can fix errors', function (string $path, string $fixedPath) {
    $file = checkFile($path);

    expect($file)->toMatchFixed($fixedPath);
})->with([
    'invalid properties' => [
        __DIR__ . '/../../../testResources/Sniffs/PhpDoc/PropertyDollarSignSniff/InvalidProperties.php',
        __DIR__ . '/../../../testResources/Sniffs/PhpDoc/PropertyDollarSignSniff/Fixed/InvalidProperties.php.fixed',
    ],
]);
