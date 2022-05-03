<?php

namespace Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource;

use Illuminate\Support\Facades\Route;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Rector\NodeTypeResolver\Node\AttributeKey;

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
        if (! $this->inspector->isApplicable($node)) {
            return [];
        }

        if (! $this->isCalledInRouteGroupClosure($node, $scope)) {
            return [];
        }

        return $this->inspector->inspect($node);
    }

    private function isCalledInRouteGroupClosure(Node\Expr\CallLike $node, Scope $scope): bool
    {
        if (! $node instanceof MethodCall) {
            return false;
        }

        if (! $scope->isInAnonymousFunction()) {
            return false;
        }

        $parent = $node->getAttribute(AttributeKey::PARENT_NODE);

        while ($parent !== null) {
            if ($parent instanceof Node\Expr\StaticCall) {
                return $parent->class->toString() === Route::class;
            }

            $parent = $parent->getAttribute(AttributeKey::PARENT_NODE);
        }

        return false;
    }
}
