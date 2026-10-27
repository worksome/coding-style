<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Sniffs\Enums;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use Worksome\CodingStyle\Utility;

class PascalCasingEnumCasesSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_ENUM_CASE,
        ];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        $nameRef = $stackPtr + 2;
        $caseName = $phpcsFile->getTokensAsString($nameRef, 1);

        if ($caseName === Utility::studly($caseName)) {
            return;
        }

        $phpcsFile->addError(
            'Enum cases MUST be PascalCase',
            $nameRef,
            self::class
        );
    }
}
