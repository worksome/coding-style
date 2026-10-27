<?php

namespace Worksome\CodingStyle\Sniffs\Laravel;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowHasFactorySniff implements Sniff
{
    private const HAS_FACTORY_FQCN = 'Illuminate\\Database\\Eloquent\\Factories\\HasFactory';

    private string|null $partial = null;

    public function register(): array
    {
        return [
            T_USE,
        ];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        $traitNamePointer = $stackPtr + 2;
        $className = explode(';', $phpcsFile->getTokensAsString($traitNamePointer, 10), 2)[0];

        $this->trackRelevantPartialNamespace($className);

        if ($this->isHasFactoryNamespace($className)) {
            $this->addError($phpcsFile, $traitNamePointer);
        }
    }

    private function isHasFactoryNamespace(string $givenNamespace): bool
    {
        if ($this->partial !== null && strlen($this->partial) > 0) {
            $lastSegment = substr((string) strrchr($this->partial, '\\'), 1);
            $givenNamespace = $this->partial . (explode($lastSegment, $givenNamespace, 2)[1] ?? $givenNamespace);
        }

        if ($givenNamespace !== self::HAS_FACTORY_FQCN) {
            return false;
        }

        return true;
    }

    private function trackRelevantPartialNamespace(string $givenNamespace): void
    {
        $namespacePartial = 'Illuminate';

        foreach (array_slice(explode('\\', self::HAS_FACTORY_FQCN), 1) as $item) {
            $namespacePartial = "{$namespacePartial}\\{$item}";

            if (str_contains($givenNamespace, $namespacePartial)) {
                $this->partial = $namespacePartial;
            }
        }
    }

    private function addError(File $phpcsFile, int $line): void
    {
        $phpcsFile->addError(
            'Models should not use the `HasFactory` trait.',
            $line,
            self::class,
        );
    }
}
