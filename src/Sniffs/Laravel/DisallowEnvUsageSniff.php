<?php

namespace Worksome\CodingStyle\Sniffs\Laravel;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowEnvUsageSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_STRING,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $string = $phpcsFile->getTokensAsString($stackPtr, 1);
        $path = $phpcsFile->getFilename();

        // Check if method is env method.
        if (strtolower($string) !== 'env') {
            return;
        }

        // Allow `env` usage in config files.
        if (str_contains($path, 'config/')) {
            return;
        }

        $phpcsFile->addError(
            'Usage of env in non-config file is disallowed.',
            $stackPtr,
            self::class
        );
    }
}
