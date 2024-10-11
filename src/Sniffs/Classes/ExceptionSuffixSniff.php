<?php

namespace Worksome\CodingStyle\Sniffs\Classes;

use Illuminate\Support\Str;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ExceptionSuffixSniff implements Sniff
{
    public string $suffix = 'Exception';

    public function register(): array
    {
        return [
            T_EXTENDS
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $baseClassNameLength = 0;

        while (Str::endsWith($phpcsFile->getTokensAsString($stackPtr + 2, $baseClassNameLength + 1), '\\')) {
            $baseClassNameLength += 2;
        }
        $baseClassName = $phpcsFile->getTokensAsString($stackPtr + 2, max($baseClassNameLength, 1));

        if (! Str::endsWith($baseClassName, $this->suffix) || ! Str::contains($baseClassName, 'Exception')) {
            return;
        }

        $classNamePointer = $stackPtr - 2;

        $className = $phpcsFile->getTokensAsString($classNamePointer, 1);

        // Check if class is named with Exceptions suffix.
        if (Str::endsWith($className, $this->suffix)) {
            return;
        }

        $phpcsFile->addError(
            'Exceptions should have `Exception` suffix.',
            $classNamePointer,
            self::class,
        );
    }
}
