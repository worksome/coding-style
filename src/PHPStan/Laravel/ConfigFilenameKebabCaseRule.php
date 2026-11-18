<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan\Laravel;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\FileNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FileNode>
 */
class ConfigFilenameKebabCaseRule implements Rule
{
    public function __construct(
        private readonly string $currentWorkingDirectory,
    ) {
    }

    public function getNodeType(): string
    {
        return FileNode::class;
    }

    /**
     * @param FileNode $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $path = str_replace('\\', '/', $scope->getFile());
        $root = rtrim(str_replace('\\', '/', $this->currentWorkingDirectory), '/') . '/';

        // Only directories within the project count, so a project checked out under a `config` directory is not matched.
        if (! str_starts_with($path, $root)) {
            return [];
        }

        $path = substr($path, strlen($root));

        if (! str_contains('/' . dirname($path) . '/', '/config/')) {
            return [];
        }

        $filename = basename($path, '.php');

        if (preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $filename) === 1) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Config files should be named with kebab-case.')
                ->identifier('worksome.laravel.configFilenameKebabCase')
                ->line(1)
                ->build(),
        ];
    }
}
