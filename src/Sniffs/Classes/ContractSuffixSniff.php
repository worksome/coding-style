<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Sniffs\Classes;

use Illuminate\Support\Str;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Ensures that any contracts that are not
 */
class ContractSuffixSniff implements Sniff
{
    public function register(): array
    {
        return [T_INTERFACE];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        if (! Str::contains($phpcsFile->getFilename(), '/Contracts/')) {
            return;
        }

        $baseClassName = $phpcsFile->getTokensAsString($stackPtr + 2, 1);

        if (! Str::endsWith($baseClassName, "Interface")) {
            return;
        }

        $phpcsFile->addError(
            "Contracts should not be suffixed with `Interface`.",
            $stackPtr,
            self::class,
        );
    }
}
