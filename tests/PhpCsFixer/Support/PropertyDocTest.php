<?php

declare(strict_types=1);

use Worksome\CodingStyle\PhpCsFixer\Support\PropertyDoc;

it('rejects content that is not a `@property` tag', function () {
    PropertyDoc::from('@param string $foo');
})->throws(InvalidArgumentException::class);

it('parses a `@property` tag', function (string $content, string $joined, bool $hasDollar) {
    $propertyDoc = PropertyDoc::from($content);

    expect($propertyDoc->joined())->toBe($joined)
        ->and($propertyDoc->variableHasDollarSymbol())->toBe($hasDollar);
})->with([
    ['@property string $foo', '@property string $foo', true],
    ['@property string foo A description', '@property string $foo A description', false],
    ['@property-read foo', '@property-read $foo', false],
]);
