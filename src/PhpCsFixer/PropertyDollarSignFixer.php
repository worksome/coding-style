<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PhpCsFixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Worksome\CodingStyle\PhpCsFixer\Support\PropertyDoc;
use const T_DOC_COMMENT;

class PropertyDollarSignFixer implements FixerInterface
{
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'All `@property` variables must start with a dollar symbol.',
            [new CodeSample("<?php\n/**\n * @property string foo\n */\nclass Bar {}\n")]
        );
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = $tokens->count() - 1; $index > 0; $index--) {
            if (! $tokens[$index]->isGivenKind(T_DOC_COMMENT)) {
                continue;
            }

            $content = $tokens[$index]->getContent();

            $newContent = Preg::replaceCallback(
                '/^(\h*\*\h*)(@property(?:-read|-write)?\h+\S.*?)(\h*)$/m',
                static function (array $matches): string {
                    $propertyDoc = PropertyDoc::from($matches[2]);

                    if ($propertyDoc->variableHasDollarSymbol()) {
                        return $matches[0];
                    }

                    return $matches[1] . $propertyDoc->joined() . $matches[3];
                },
                $content,
            );

            if ($newContent === $content) {
                continue;
            }

            $tokens[$index] = new Token([T_DOC_COMMENT, $newContent]);
        }
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(T_DOC_COMMENT);
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return 'Worksome/property_dollar_sign';
    }

    public function getPriority(): int
    {
        return 0;
    }

    public function supports(SplFileInfo $file): bool
    {
        return true;
    }
}
