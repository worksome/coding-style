<?php

namespace Worksome\CodingStyle\Sniffs\PhpDoc;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowParamNoTypeOrCommentSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_DOC_COMMENT_TAG,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        // Check if @param
        if (! str_contains($phpcsFile->getTokensAsString($stackPtr, 1), '@param')) {
            return;
        }

        $value = $phpcsFile->getTokensAsString($stackPtr+2, 1);

        // Check if param tag with no type or comment
        $regex = '/^\$\w+\s*$/m';

        if (! \Safe\preg_match($regex, $value, $matches)) {
            return;
        }

        $phpcsFile->addFixableError(
            "@param tags with no type or comment are disallowed",
            $stackPtr,
            self::class
        );

        foreach (range(-4, 2) as $pointer) {
            $phpcsFile->fixer->replaceToken(
                $stackPtr+$pointer,
                ""
            );
        }
    }
}
