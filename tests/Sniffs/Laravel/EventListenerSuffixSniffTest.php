<?php

namespace Worksome\CodingStyle\Tests\Sniffs\Laravel;

use Worksome\CodingStyle\Sniffs\Laravel\EventListenerSuffixSniff;

beforeEach(function () {
    $this->sniff = EventListenerSuffixSniff::class;
});

it('has no errors', function (string $path) {
    $report = checkFile($path);

    expect($report)->toHaveNoSniffErrors();
})->with([
    'has suffix' => __DIR__ . '/../../../testResources/Sniffs/Laravel/EventListenerSuffixSniff/app/Listeners/CorrectListenerNameListener.php',
]);

it('has errors', function (string $path, int $line) {
    $report = checkFile($path);

    expect($report)
        ->toHaveSniffErrors(1)
        ->toHaveSniffError(line: $line);
})->with([
    'has compact call' => [
        __DIR__ . '/../../../testResources/Sniffs/Laravel/EventListenerSuffixSniff/app/Listeners/WrongListenerName.php',
        5
    ],
]);

it('can change suffix', function () {
    $report = checkFile(
        __DIR__ . '/../../../testResources/Sniffs/Laravel/EventListenerSuffixSniff/app/Listeners/ChangedSuffixListener.php',
        [
            'suffix' => 'Hears',
        ]
    );

    expect($report)
        ->toHaveSniffErrors(1)
        ->toHaveSniffError(line: 5);
});
