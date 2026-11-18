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
