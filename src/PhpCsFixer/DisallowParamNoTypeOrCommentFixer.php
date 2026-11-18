<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PhpCsFixer;

use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\DocBlock\Line;
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

            $lines = $docBlock->getLines();

            foreach ($docBlock->getAnnotationsOfType('param') as $annotation) {
                if ($this->hasContinuation($lines, $annotation->getEnd())) {
                    continue;
                }

                if (! Preg::match(
                    '/^\h*(?:\/\*\*|\*)?\h*@param\h+&?\h*(?:\.\.\.)?\h*\$\w+\s*(?:\*\/)?\s*$/',
                    $annotation->getContent()
                )) {
                    continue;
                }

                $annotation->remove();
            }

            $newContent = $docBlock->getContent();

            if ($newContent === $tokens[$index]->getContent()) {
                continue;
            }

            // A single-line docblock is removed entirely, so leave an empty docblock for NoEmptyPhpdocFixer to tidy up.
            // NoEmptyPhpdocFixer requires a following token, so a docblock at the end of the file is removed here.
            $isEmpty = Preg::match('/^\s*(?:\/\*\*)?[\s*]*(?:\*\/)?\s*$/', $newContent);

            if ($isEmpty && $index === $tokens->count() - 1) {
                $tokens->clearTokenAndMergeSurroundingWhitespace($index);

                continue;
            }

            if ($newContent === '') {
                $newContent = '/** */';
            }

            $tokens[$index] = new Token([T_DOC_COMMENT, $newContent]);
        }
    }

    /**
     * Whether the tag's description continues after the annotation ends.
     *
     * PHP-CS-Fixer ends an annotation at a blank line, or at a line containing `* @` (such as a Markdown list item like
     *
     * `* * @see ...`), so the tag is only treated as bare when the next non-blank line starts a real tag or ends the
     * docblock.
     *
     * @param array<int, Line> $lines
     */
    private function hasContinuation(array $lines, int $annotationEnd): bool
    {
        for ($index = $annotationEnd + 1; isset($lines[$index]); $index++) {
            $content = rtrim($lines[$index]->getContent(), "\r\n");

            if (Preg::match('/^\h*\*\h*$/', $content)) {
                continue;
            }

            return ! Preg::match('/^\h*(?:\*\h*@|\*\/)/', $content);
        }

        return false;
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
