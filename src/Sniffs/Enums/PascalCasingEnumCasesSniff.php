<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Sniffs\Enums;

use Illuminate\Support\Str;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class PascalCasingEnumCasesSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_ENUM_CASE,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $nameRef = $stackPtr + 2;
        $caseName = $phpcsFile->getTokensAsString($nameRef, 1);

        if ($caseName === Str::studly($caseName)) {
            return;
        }

        $phpcsFile->addError(
            'Enum cases MUST be PascalCase',
            $nameRef,
            self::class
        );
    }
}
