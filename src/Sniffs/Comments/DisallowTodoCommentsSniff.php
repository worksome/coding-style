<?php

namespace Worksome\CodingStyle\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowTodoCommentsSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_COMMENT,
            T_DOC_COMMENT_TAG,
            T_DOC_COMMENT_STRING,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        // Check if a to do string
        if (stripos($phpcsFile->getTokensAsString($stackPtr, 1), 'TODO') === false) {
            return;
        }

        $phpcsFile->addError(
            'Comments with TODO are disallowed',
            $stackPtr,
            self::class
        );
    }
}
