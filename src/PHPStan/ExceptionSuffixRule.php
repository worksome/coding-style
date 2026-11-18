<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Throwable;

/**
 * @implements Rule<InClassNode>
 */
class ExceptionSuffixRule implements Rule
{
    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    /**
     * @param InClassNode $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $node->getClassReflection();

        if (! $classReflection->isClass() || $classReflection->isAnonymous()) {
            return [];
        }

        if (! $classReflection->implementsInterface(Throwable::class)) {
            return [];
        }

        if (str_ends_with($classReflection->getName(), 'Exception')) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Exceptions should have `Exception` suffix.')
                ->identifier('worksome.exceptionSuffix')
                ->line($node->getOriginalNode()->name?->getStartLine() ?? $node->getStartLine())
                ->build(),
        ];
    }
}
