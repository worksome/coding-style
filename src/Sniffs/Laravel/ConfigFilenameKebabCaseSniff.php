<?php

namespace Worksome\CodingStyle\Sniffs\Laravel;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use Worksome\CodingStyle\Utility;

class ConfigFilenameKebabCaseSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_OPEN_TAG,
        ];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        $path = $phpcsFile->getFilename();

        // Filter away non config files.
        if (! str_contains($path, 'config/')) {
            return;
        }

        $filenameWithExtension = basename($path);
        $filename = explode('.', $filenameWithExtension, 2)[0];

        if (Utility::kebab($filename) === $filename) {
            return;
        }

        $phpcsFile->addError(
            'Config files should be named with kebab-case.',
            0,
            self::class,
        );
    }
}
