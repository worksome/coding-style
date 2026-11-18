<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PhpCsFixer;

use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use const T_DOC_COMMENT;

class DisallowParamNoTypeOrCommentFixer implements FixerInterface
{
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            '`@param` tags with no type or comment must be removed.',
            [new CodeSample("<?php\n/**\n * @param \$foo\n */\nfunction bar(\$foo) {}\n")]
        );
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = $tokens->count() - 1; $index > 0; $index--) {
            if (! $tokens[$index]->isGivenKind(T_DOC_COMMENT)) {
                continue;
            }

            $docBlock = new DocBlock($tokens[$index]->getContent());

            foreach ($docBlock->getAnnotationsOfType('param') as $annotation) {
                if (! Preg::match('/@param\h+&?(?:\.\.\.)?\$\w+\s*(?:\*\/)?\s*$/', $annotation->getContent())) {
                    continue;
                }

                $annotation->remove();
            }

            $newContent = $docBlock->getContent();

            if ($newContent === $tokens[$index]->getContent()) {
                continue;
            }

            // A single-line docblock is removed entirely, so leave an empty docblock for NoEmptyPhpdocFixer to tidy up.
            if ($newContent === '') {
                $newContent = '/** */';
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
        return 'Worksome/disallow_param_no_type_or_comment';
    }

    /**
     * Must run before NoEmptyPhpdocFixer, so that docblocks emptied by this fixer are removed.
     */
    public function getPriority(): int
    {
        return 4;
    }

    public function supports(SplFileInfo $file): bool
    {
        return true;
    }
}
