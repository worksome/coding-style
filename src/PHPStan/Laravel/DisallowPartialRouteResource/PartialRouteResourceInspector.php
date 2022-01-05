<?php

namespace Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource;

use Illuminate\Support\Facades\Route;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Analyser\Scope;

final class PartialRouteResourceInspector
{
    /**
     * @var string[]
     */
    private array $resourceMethods = [
        'resource',
        'apiResource',
    ];

    /**
     * @var string[]
     */
    private array $partialMethods = [
        'except',
        'only',
    ];

    public function inspect(Node $node, Scope $scope): array
    {
        if (! $this->isApplicable($node, $scope)) {
            return [];
        }

        $next = $node->getAttribute('next');

        while ($next !== null) {
            if (in_array($next->name, $this->partialMethods)) {
                return [$this->errorFor($next->name)];
            }

            $next = $next->getAttribute('parent')->getAttribute('next');
        }

        return [];
    }

    public function isApplicable(Node $node, Scope $scope): bool
    {
        if (! $node instanceof Node\Expr\CallLike) {
            return false;
        }

        if (! in_array($node->name->name, $this->resourceMethods)) {
            return false;
        }

        if ($this->isCalledOnRouteFacade($node)) {
            return true;
        }

        return $this->isCalledInRouteGroupClosure($node, $scope);
    }

    private function isCalledOnRouteFacade(Node\Expr\CallLike $node): bool
    {
        if (! $node instanceof StaticCall) {
            return false;
        }

        return $node->class->toString() === Route::class;
    }

    private function isCalledInRouteGroupClosure(Node\Expr\CallLike $node, Scope $scope): bool
    {
        if (! $node instanceof MethodCall) {
            return false;
        }

        if (! $scope->isInAnonymousFunction()) {
            return false;
        }

        $parent = $node->getAttribute('parent');

        while ($parent !== null) {
            if ($parent instanceof Node\Expr\StaticCall) {
                return $parent->class->toString() === Route::class;
            }

            $parent = $parent->getAttribute('parent');
        }

        return false;
    }

    private function errorFor(string $method): RuleError
    {
        return RuleErrorBuilder::message(
            "Usage of [{$method}] method on route resource is disallowed. Please split the resource into multiple routes."
        )->build();
    }
}