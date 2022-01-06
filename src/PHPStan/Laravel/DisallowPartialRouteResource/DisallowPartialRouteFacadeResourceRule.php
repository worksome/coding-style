<?php

namespace Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource;

use Illuminate\Support\Facades\Route;
use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;

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
        if (! $this->inspector->isApplicable($node)) {
            return [];
        }

        if (! $this->isCalledOnRouteFacade($node)) {
            return [];
        }

        return $this->inspector->inspect($node);
    }

    private function isCalledOnRouteFacade(Node $node): bool
    {
        if (! $node instanceof StaticCall) {
            return false;
        }

        return $node->class->toString() === Route::class;
    }
}
