<?php

namespace Worksome\CodingStyle\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ExceptionSuffixSniff implements Sniff
{
    public string $suffix = 'Exception';

    public function register(): array
    {
        return [
            T_EXTENDS,
        ];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        $baseClassNameLength = 0;

        while (str_ends_with($phpcsFile->getTokensAsString($stackPtr + 2, $baseClassNameLength + 1), '\\')) {
            $baseClassNameLength += 2;
        }
        $baseClassName = $phpcsFile->getTokensAsString($stackPtr + 2, max($baseClassNameLength, 1));

        if (! str_ends_with($baseClassName, $this->suffix) || ! str_contains($baseClassName, 'Exception')) {
            return;
        }

        $classNamePointer = $stackPtr - 2;

        $className = $phpcsFile->getTokensAsString($classNamePointer, 1);

        // Check if class is named with Exceptions suffix.
        if (str_ends_with($className, $this->suffix)) {
            return;
        }

        $phpcsFile->addError(
            'Exceptions should have `Exception` suffix.',
            $classNamePointer,
            self::class,
        );
    }
}
