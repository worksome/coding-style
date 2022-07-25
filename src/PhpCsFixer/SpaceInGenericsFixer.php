<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PhpCsFixer;

use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use const T_DOC_COMMENT;

/** @link https://github.com/kubawerlos/php-cs-fixer-custom-fixers Modified from "PhpdocTypesCommaSpacesFixer" */
class SpaceInGenericsFixer implements FixerInterface
{
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'PHPDoc generic types must contain a single space after the comma.',
            [new CodeSample("<?php /** @var array<class-string,bool> */\n")]
        );
    }

    protected function fixType(string $type): string
    {
        $newType = preg_replace('/\h*,\s*/', ', ', $type);

        if ($newType === $type) {
            return $type;
        }

        return $this->fixType($newType);
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = $tokens->count() - 1; $index > 0; $index--) {
            if (! $tokens[$index]->isGivenKind([T_DOC_COMMENT])) {
                continue;
            }

            $docBlock = new DocBlock($tokens[$index]->getContent());

            foreach ($docBlock->getAnnotations() as $annotation) {
                if (! $annotation->supportTypes()) {
                    continue;
                }

                $type = $annotation->getTypeExpression()->toString();
                $type = $this->fixType($type);
                $annotation->setTypes([$type]);
            }

            $newContent = $docBlock->getContent();
            if ($newContent === $tokens[$index]->getContent()) {
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
        return 'space_in_generics';
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
