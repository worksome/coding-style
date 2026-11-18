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
class DisallowBladeOutsideOfResourcesDirectoryRule implements Rule
{
    public function __construct(
        private readonly string $resourcesDirectory,
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
        $file = $this->normalisePath($scope->getFile());

        if (! str_ends_with($file, '.blade.php')) {
            return [];
        }

        if (str_starts_with($file, rtrim($this->resourcesDirectory(), '/') . '/')) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Blade files must be placed in the resources directory.')
                ->identifier('worksome.laravel.disallowBladeOutsideOfResourcesDirectory')
                ->line(1)
                ->build(),
        ];
    }

    private function resourcesDirectory(): string
    {
        $directory = $this->normalisePath($this->resourcesDirectory);

        if (! str_starts_with($directory, '/') && preg_match('/^[A-Za-z]:\//', $directory) !== 1) {
            $directory = $this->normalisePath($this->currentWorkingDirectory) . '/' . $directory;
        }

        return $this->normalisePath($directory);
    }

    /**
     * Use forward slashes, and resolve `.` and `..` segments.
     */
    private function normalisePath(string $path): string
    {
        $path = str_replace('\\', '/', $path);
        $prefix = preg_match('/^(?:[A-Za-z]:)?\//', $path, $matches) === 1 ? $matches[0] : '';
        $segments = [];

        foreach (explode('/', substr($path, strlen($prefix))) as $segment) {
            if ($segment === '' || $segment === '.') {
                continue;
            }

            if ($segment === '..') {
                array_pop($segments);

                continue;
            }

            $segments[] = $segment;
        }

        return $prefix . implode('/', $segments);
    }
}
