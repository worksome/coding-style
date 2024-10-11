<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @implements Rule<Class_>
 */
final class DisallowPHPUnitRule implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->isAbstract()) {
            return [];
        }

        if ($node->namespacedName === null) {
            return [];
        }

        if (! is_subclass_of($node->namespacedName->toString(), TestCase::class)) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                'PHPUnit tests are not allowed. Please use Pest PHP instead. If this is a TestCase, make it abstract to pass validation.'
            )
                ->identifier('worksome.disallowPhpunit')
                ->build(),
        ];
    }
}
