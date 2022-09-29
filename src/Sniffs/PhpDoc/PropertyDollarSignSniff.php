<?php

namespace Worksome\CodingStyle\Sniffs\PhpDoc;

use InvalidArgumentException;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use Worksome\CodingStyle\Sniffs\Support\PropertyDoc;

class PropertyDollarSignSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_DOC_COMMENT_TAG,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        try {
            $propertyDoc = PropertyDoc::from($this->getLineOfDocblock($phpcsFile, $stackPtr));
        } catch (InvalidArgumentException) {
            return;
        }

        if ($propertyDoc->variableHasDollarSymbol()) {
            return;
        }

        $phpcsFile->addFixableError(
            "All @property variables should start with a dollar symbol.",
            $stackPtr,
            self::class
        );

        if ($phpcsFile->fixer === null) {
            return;
        }

        $this->replaceLineOfDocblock($phpcsFile, $stackPtr, " {$propertyDoc->joined()}" . PHP_EOL);
    }

    private function getLineOfDocblock(File $phpcsFile, int $startPtr): string
    {
        $currentPointer = $startPtr;
        $content = '';

        while (! str_ends_with($content, PHP_EOL)) {
            if ($phpcsFile->numTokens === $currentPointer) {
                continue;
            }

            $content .= $phpcsFile->getTokensAsString($currentPointer, 1);
            $currentPointer += 1;
        }

        return trim($content);
    }

    private function replaceLineOfDocblock(File $phpcsFile, int $startPtr, string $newContent): void
    {
        $eolPointer = $startPtr;
        $content = '';

        do {
            if ($phpcsFile->numTokens === $eolPointer) {
                continue;
            }

            $eolPointer += 1;
            $content = $phpcsFile->getTokensAsString($eolPointer, 1);
        } while (! str_ends_with($content, PHP_EOL));

        foreach (array_reverse(range($startPtr, $eolPointer)) as $ptrToDelete) {
            $phpcsFile->fixer->replaceToken($ptrToDelete, '');
        }

        $phpcsFile->fixer->replaceToken($startPtr - 1, $newContent);
    }
}
