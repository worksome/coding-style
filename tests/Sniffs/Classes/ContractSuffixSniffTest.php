<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Tests\Sniffs\Classes;

use Worksome\CodingStyle\Sniffs\Classes\ContractSuffixSniff;

beforeEach(function () {
    $this->sniff = ContractSuffixSniff::class;
});

it('has no errors', function (string $path) {
    $report = checkFile($path);

    expect($report)->toHaveNoSniffErrors();
})->with([
    __DIR__ . '/../../../testResources/Sniffs/Classes/ContractSuffixSniff/WithSuffixInterface.php'
]);

it('has errors', function (string $path, int $line) {
    $report = checkFile($path);

    expect($report)
        ->toHaveSniffErrors(1)
        ->toHaveSniffError($line);
})->with([
    'At root of Contracts directory' => [
        __DIR__ . '/../../../testResources/Sniffs/Classes/ContractSuffixSniff/Contracts/WithSuffixInterface.php',
        9
    ],
    'In subdirectory of Contracts directory' => [
        __DIR__ . '/../../../testResources/Sniffs/Classes/ContractSuffixSniff/Contracts/Subdirectory/WithSuffixInterface.php',
        9
    ],
]);
