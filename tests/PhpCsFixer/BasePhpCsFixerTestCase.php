<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Tests\PhpCsFixer;

use InvalidArgumentException;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Tokenizer\Tokens;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class BasePhpCsFixerTestCase extends TestCase
{
    protected FixerInterface $fixer;

    protected function setFixer(FixerInterface $fixer): self
    {
        $this->fixer = $fixer;

        return $this;
    }

    final protected function doTest(string $expected, string|null $input = null, array|null $configuration = null): void
    {
        if ($this->fixer instanceof ConfigurableFixerInterface) {
            $this->fixer->configure($configuration ?? []);
        }

        if ($expected === $input) {
            throw new InvalidArgumentException('Expected must be different to input.');
        }

        Tokens::clearCache();
        $expectedTokens = Tokens::fromCode($expected);

        if ($input !== null) {
            Tokens::clearCache();
            $inputTokens = Tokens::fromCode($input);

            $this->fixer->fix($this->createMock(SplFileInfo::class), $inputTokens);
            $inputTokens->clearEmptyTokens();

            expect($inputTokens->generateCode())->toBe($expected);
        }

        $this->fixer->fix($this->createMock(SplFileInfo::class), $expectedTokens);

        expect($expectedTokens->generateCode())->toBe($expected)
            ->and($expectedTokens->isChanged())->toBeFalse();
    }
}
