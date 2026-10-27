<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @implements Rule<InClassNode>
 */
final class DisallowPHPUnitRule implements Rule
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

        if ($classReflection->isAbstract() || $classReflection->isAnonymous()) {
            return [];
        }

        if (! $classReflection->isSubclassOf(TestCase::class)) {
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
