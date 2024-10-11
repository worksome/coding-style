<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan\Laravel\Migrations;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Illuminate\Support\Str;

/**
 * Custom PHPStan rule to check if migration files using 'update' or 'insert'
 * methods include 'withoutTimestamps' somewhere in the file.
 */
class RequireWithoutTimestampsRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Class_::class;
    }

    /**
     * @param Node\Stmt\Class_ $node
     * @param Scope $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $filePath = $scope->getFile();

        if (! Str::contains($filePath, 'database/migrations')) {
            return [];
        }

        $fileContent = file_get_contents($filePath);

        if (preg_match('/\b(update|insert|save|saveQuietly|create)\s*\(/', $fileContent)) {
            if (!str_contains($fileContent, 'withoutTimestamps')) {
                $filenameWithExtension = basename($filePath);
                $filename = Str::before($filenameWithExtension, '.');

                return [
                    RuleErrorBuilder::message(
                        "$filename file uses 'update' or 'create' action without 'withoutTimestamps()' protection."
                    )
                        ->identifier('worksome.requireWithoutTimestamps')
                        ->build(),
                ];
            }
        }

        return [];
    }
}
