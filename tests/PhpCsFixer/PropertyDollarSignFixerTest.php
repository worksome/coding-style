<?php

declare(strict_types=1);

use Worksome\CodingStyle\PhpCsFixer\PropertyDollarSignFixer;

beforeEach(fn () => $this->setFixer(new PropertyDollarSignFixer()));

it('is not a risky fixer', function () {
    expect($this->fixer->isRisky())->toBeFalse();
});

it('adds a dollar sign to `@property` variables', function (string $expected, string|null $input = null) {
    $this->doTest($expected, $input);
})->with(function () {
    yield 'valid properties are untouched' => [
        '<?php
/**
 * @property array<string, string> $foo
 * @property array<string,string> $bam
 * @property array{foo: string, bar: int} $foobar
 * @property string $bar
 * @property int $baz that is really cool
 * @property string|int $foz
 * @property $for kinda cool
 * @property $far
 * @property int    $test
 * @property int[] $integers
 * @property string|int[] $stringsOrIntegers
 * @property \Illuminate\Support\Collection $myCollection
 */
class ValidProperties {}
',
    ];

    yield 'invalid properties are fixed' => [
        '<?php
/**
 * @property string $foo
 * @property int $bar
 * @property bar $works well
 * @property Collection<int, callable(string): bool|null> $boom This is a collection
 * @property array{foo: string, bar: array<int, string>} | null $bam This is a collection
 * @property-read $foo
 * @property string[] $whoops
 * @property positive-int $nice_int
 * @property non-empty-array<\Exception> $non_empty_array
 * @property ABC|EFG $union_type
 * @property ABC&EFG $intersection_type
 */
class InvalidProperties {}
',
        '<?php
/**
 * @property string foo
 * @property int bar
 * @property bar works well
 * @property Collection<int, callable(string): bool|null> boom This is a collection
 * @property array{foo: string, bar: array<int, string>} | null bam This is a collection
 * @property-read foo
 * @property string[] whoops
 * @property positive-int nice_int
 * @property non-empty-array<\Exception> non_empty_array
 * @property ABC|EFG union_type
 * @property ABC&EFG intersection_type
 */
class InvalidProperties {}
',
    ];

    yield 'single-line docblocks are fixed' => [
        '<?php
/** @property string $foo */
class SingleLine {}
',
        '<?php
/** @property string foo */
class SingleLine {}
',
    ];

    yield 'tab-separated properties are fixed' => [
        "<?php
/**
 * @property\tstring\t\$foo
 */
class Tabs {}
",
        "<?php
/**
 * @property\tstring\tfoo
 */
class Tabs {}
",
    ];

    yield 'callable types are not mistaken for the name' => [
        '<?php
/**
 * @property callable(string): bool $handler
 * @property \Closure(int, string): void $other
 */
class Callables {}
',
        '<?php
/**
 * @property callable(string): bool handler
 * @property \Closure(int, string): void other
 */
class Callables {}
',
    ];

    yield 'unparseable properties are untouched' => [
        '<?php
/**
 * @property ...
 * @property array<int,
 * @property string $valid
 */
class Unparseable {}
',
        '<?php
/**
 * @property ...
 * @property array<int,
 * @property string valid
 */
class Unparseable {}
',
    ];

    yield 'already valid callable properties are untouched' => [
        '<?php
/**
 * @property callable(string): bool $handler
 */
class ValidCallable {}
',
    ];

    yield 'types continuing on the next line are untouched' => [
        '<?php
/**
 * @property Foo
 *     |Bar $value
 * @property string $name
 */
class Multiline {}
',
        '<?php
/**
 * @property Foo
 *     |Bar $value
 * @property string name
 */
class Multiline {}
',
    ];

    yield 'descriptions on the next line starting with punctuation do not block the fix' => [
        '<?php
/**
 * @property string $name
 * [More details](#details)
 */
class Punctuation {}
',
        '<?php
/**
 * @property string name
 * [More details](#details)
 */
class Punctuation {}
',
    ];
});

it('has valid fixer metadata', function () {
    expect($this->fixer->getName())->toBe('Worksome/property_dollar_sign')
        ->and($this->fixer->supports(new SplFileInfo(__FILE__)))->toBeTrue()
        ->and($this->fixer->getPriority())->toBeInt()
        ->and(
            $this->fixer->isCandidate(PhpCsFixer\Tokenizer\Tokens::fromCode("<?php /** @var int */ \$a = 1;\n"))
        )->toBeTrue()
        ->and($this->fixer->isCandidate(PhpCsFixer\Tokenizer\Tokens::fromCode("<?php \$a = 1;\n")))->toBeFalse();
});

it('fixes its own code sample', function () {
    $sample = $this->fixer->getDefinition()->getCodeSamples()[0]->getCode();
    $tokens = PhpCsFixer\Tokenizer\Tokens::fromCode($sample);

    $this->fixer->fix(new SplFileInfo(__FILE__), $tokens);

    expect($tokens->isChanged())->toBeTrue();
});
