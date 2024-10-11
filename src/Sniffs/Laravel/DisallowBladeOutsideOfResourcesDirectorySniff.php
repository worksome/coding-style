<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Sniffs\Laravel;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowBladeOutsideOfResourcesDirectorySniff implements Sniff
{
    public string|null $resourcesDirectory = null;

    private bool $errorAlreadyRegisteredForFile = false;

    public function register(): array
    {
        return [T_INLINE_HTML];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        if (! str_ends_with($phpcsFile->getFilename(), '.blade.php')) {
            return;
        }

        if (str_contains($phpcsFile->getFilename(), $this->resourcesDirectory())) {
            return;
        }

        if ($this->errorAlreadyRegisteredForFile) {
            return;
        }

        $phpcsFile->addError(
            'Blade files must be placed in the resources directory.',
            $stackPtr,
            self::class
        );

        $this->errorAlreadyRegisteredForFile = true;
    }

    private function resourcesDirectory(): string
    {
        return $this->resourcesDirectory ?? getcwd() . DIRECTORY_SEPARATOR . 'resources';
    }
}
