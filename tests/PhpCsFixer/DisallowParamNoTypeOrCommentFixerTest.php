<?php

declare(strict_types=1);

use Worksome\CodingStyle\PhpCsFixer\DisallowParamNoTypeOrCommentFixer;

beforeEach(fn () => $this->setFixer(new DisallowParamNoTypeOrCommentFixer()));

it('is not a risky fixer', function () {
    expect($this->fixer->isRisky())->toBeFalse();
});

it('removes `@param` tags with no type or comment', function (string $expected, string|null $input = null) {
    $this->doTest($expected, $input);
})->with(function () {
    yield 'valid tags are untouched' => [
        '<?php
    /**
     * @param string $name
     * @param $type some random type
     * @param array $other
     * @param array $last with comment
     */
    function someMethod($name, $type, $other, $last): void {}
',
    ];

    yield 'tags with no type or comment are removed' => [
        '<?php
    /**
     * @param string $name
     * @param $type some random type
     */
    function someMethod($name, $type, $other): void {}
',
        '<?php
    /**
     * @param string $name
     * @param $type some random type
     * @param $other
     */
    function someMethod($name, $type, $other): void {}
',
    ];

    yield 'variadic and by-reference tags are removed' => [
        '<?php
    /**
     * @param string $name
     */
    function someMethod($name, &$ref, ...$rest): void {}
',
        '<?php
    /**
     * @param string $name
     * @param &$ref
     * @param ...$rest
     */
    function someMethod($name, &$ref, ...$rest): void {}
',
    ];

    yield 'single-line docblocks are emptied' => [
        '<?php
    /** */
    function someMethod($name): void {}
',
        '<?php
    /** @param $name */
    function someMethod($name): void {}
',
    ];

    yield 'multi-line descriptions are untouched' => [
        '<?php
    /**
     * @param $name
     *     A description on the next line.
     */
    function someMethod($name): void {}
',
    ];

    yield 'a `@param` mentioned in a description is untouched' => [
        '<?php
    /**
     * @param string $name See @param $other
     */
    function someMethod($name): void {}
',
    ];

    yield 'modifiers separated by whitespace are removed' => [
        '<?php
    /**
     * @param string $name
     */
    function someMethod($name, &...$args): void {}
',
        '<?php
    /**
     * @param string $name
     * @param & ...$args
     */
    function someMethod($name, &...$args): void {}
',
    ];

    yield 'tags continued by a Markdown list are untouched' => [
        '<?php
    /**
     * @param $path
     * * @see Path::normalize() before passing this value.
     */
    function someMethod($path): void {}
',
    ];

    yield 'a docblock at the end of the file is removed' => [
        '<?php
',
        '<?php
/** @param $x */',
    ];

    yield 'tags continued by a Markdown list after a blank line are untouched' => [
        '<?php
    /**
     * @param $path
     *
     * * @see Path::normalize() before passing this value.
     */
    function someMethod($path): void {}
',
    ];

    yield 'a multi-line docblock at the end of the file is removed' => [
        '<?php
',
        '<?php
/**
 * @param $x
 */',
    ];
});

it('has valid fixer metadata', function () {
    expect($this->fixer->getName())->toBe('Worksome/disallow_param_no_type_or_comment')
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
