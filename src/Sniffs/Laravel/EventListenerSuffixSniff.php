<?php

namespace Worksome\CodingStyle\Sniffs\Laravel;

use Illuminate\Support\Str;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class EventListenerSuffixSniff implements Sniff
{
    public string $suffix = 'Listener';

    public function register(): array
    {
        return [
            T_CLASS,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $path = $phpcsFile->getFilename();

        // Filter away non listener classes
        if (! str_contains($path, 'app/Listeners/')) {
            return;
        }

        $classNamePointer = $stackPtr + 2;
        $className = $phpcsFile->getTokensAsString($classNamePointer, 1);

        // Check if class is named with Listener suffix.
        if (Str::endsWith($className, $this->suffix)) {
            return;
        }

        $phpcsFile->addError(
            'Listeners should have `Listener` suffix.',
            $classNamePointer,
            self::class,
        );
    }
}
