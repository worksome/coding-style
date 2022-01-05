<?php

namespace Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<Node\Expr\MethodCall>
 */
class DisallowPartialRouteVariableResourceRule implements Rule
{
    public function __construct(private PartialRouteResourceInspector $inspector)
    {
    }

    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    /**
     * @param Node\Expr\MethodCall $node
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $this->inspector->inspect($node, $scope);
    }
}
