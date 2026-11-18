<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan\Laravel;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\FileNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Worksome\CodingStyle\Utility;

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
        $path = str_replace(DIRECTORY_SEPARATOR, '/', $scope->getFile());

        if (! str_contains($path, 'config/')) {
            return [];
        }

        $filename = explode('.', basename($path), 2)[0];

        if (Utility::kebab($filename) === $filename) {
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
