<?php

namespace Worksome\CodingStyle\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowCompactUsageSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_STRING,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $methodName = $phpcsFile->getTokensAsString($stackPtr, 1);

        // Check if method is env method.
        if (strtolower($methodName) !== 'compact') {
            return;
        }

        $phpcsFile->addFixableError(
            "Usage of compact function is disallowed.",
            $stackPtr,
            self::class
        );

        [$variables, $lastTokenPointer] = $this->findVariablesInCompactCall($phpcsFile, $stackPtr);

        $phpCode = $this->generatePhpArray($variables);

        // Remove all the old code after the `compact` string.
        foreach (range(1, $lastTokenPointer-1) as $currentPointer) {
            $phpcsFile->fixer->replaceToken(
                $stackPtr+$currentPointer,
                ""
            );
        }

        // Replace the `compact` string with our new array.
        $phpcsFile->fixer->replaceToken(
            $stackPtr,
            $phpCode
        );
    }

    private function generatePhpArray(array $variables): string
    {
        $phpCode = '[';
        foreach ($variables as $variable) {
            $phpCode .= "'$variable' => \$$variable, ";
        }

        // Remove the trailing `, ` from the array.
        $phpCode = substr($phpCode, 0, -2);
        // Close the array
        $phpCode .= "]";

        return $phpCode;
    }

    private function findVariablesInCompactCall(File $phpcsFile, int $stackPtr): array
    {
        $variables = [];
        $pointer = 1;

        do {
            $token = $phpcsFile->getTokensAsString($stackPtr + $pointer, 1);
            $pointer++;

            if (! \Safe\preg_match("/['\"](.*?)['\"]/", $token, $matches)) {
                continue;
            }

            $variableName = $matches[1];
            $variables[] = $variableName;
        } while ($token !== ')');

        return [$variables, $pointer, $matches];
    }
}
