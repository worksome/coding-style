<?php

namespace Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node\Expr\StaticCall>
 */
class DisallowPartialRouteFacadeResourceRule implements Rule
{
    public function __construct(private PartialRouteResourceInspector $inspector)
    {
    }

    public function getNodeType(): string
    {
        return Node\Expr\StaticCall::class;
    }

    /**
     * @param Node\Expr\StaticCall $node
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $this->inspector->inspect($node, $scope);
    }
}
