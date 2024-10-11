<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan\Laravel\Migrations;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PHPStan\Analyser\Scope;
use PHPStan\Node\FileNode;
use PHPStan\Rules\Rule;

/**
 * Custom PHPStan rule to check if migration files using 'update' or 'insert'
 * methods include 'withoutTimestamps' somewhere in the file.
 */
readonly class RequireWithoutTimestampsRule implements Rule
{
    public function __construct(private string $migrationsPath = 'database/migrations')
    {
    }

    public function getNodeType(): string
    {
        return FileNode::class;
    }

    /**
     * @param FileNode $node
     * @param Scope    $scope
     *
     * @return string[] Errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $filePath = $scope->getFile();

        if (! str_contains($filePath, $this->migrationsPath)) {
            return [];
        }

        $traverser = new NodeTraverser();
        $visitor = new WithoutTimestampsVisitor();
        $traverser->addVisitor($visitor);
        $traverser->traverse($node->getNodes());

        return $visitor->errors;
    }
}
