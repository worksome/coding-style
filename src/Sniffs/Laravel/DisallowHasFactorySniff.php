<?php

namespace Worksome\CodingStyle\Sniffs\Laravel;

use Illuminate\Support\Str;
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

    public function process(File $phpcsFile, $stackPtr)
    {
        $traitNamePointer = $stackPtr + 2;
        $className = Str::before($phpcsFile->getTokensAsString($traitNamePointer, 10), ';');

        $this->trackRelevantPartialNamespace($className);

        if ($this->isHasFactoryNamespace($className)) {
            $this->addError($phpcsFile, $traitNamePointer);
        }
    }

    private function isHasFactoryNamespace(string $givenNamespace): bool
    {
        if ($this->partial !== null && strlen($this->partial) > 0) {
            $givenNamespace = $this->partial . Str::after($givenNamespace, Str::afterLast($this->partial, '\\'));
        }

        if ($givenNamespace !== self::HAS_FACTORY_FQCN) {
            return false;
        }

        return true;
    }

    private function trackRelevantPartialNamespace(string $givenNamespace): void
    {
        Str::of(self::HAS_FACTORY_FQCN)
            ->explode('\\')
            ->skip(1)
            ->reduce(function (string $carry, string $item) use ($givenNamespace) {
                $updatedNamespacePartial = "{$carry}\\{$item}";

                if (Str::contains($givenNamespace, $updatedNamespacePartial)) {
                    $this->partial = $updatedNamespacePartial;
                }

                return $updatedNamespacePartial;
            }, 'Illuminate');
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
