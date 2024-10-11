<?php

namespace Worksome\CodingStyle\Sniffs\Laravel;

use Illuminate\Support\Str;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ConfigFilenameKebabCaseSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_OPEN_TAG
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $path = $phpcsFile->getFilename();

        // Filter away non config files.
        if (! str_contains($path, 'config/')) {
            return;
        }

        $filenameWithExtension = basename($path);
        $filename = Str::before($filenameWithExtension, '.');

        if (Str::kebab($filename) === $filename) {
            return;
        }

        $phpcsFile->addError(
            'Config files should be named with kebab-case.',
            0,
            self::class,
        );
    }
}
