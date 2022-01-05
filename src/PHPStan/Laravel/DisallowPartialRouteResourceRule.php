<?php

namespace Worksome\CodingStyle\PHPStan\Laravel;

use Illuminate\Support\Facades\Route;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FuncCall>
 */
class DisallowPartialRouteResourceRule implements Rule
{
    private array $resourceMethods = [
        'resource',
        'apiResource',
    ];

    private array $partialMethods = [
        'except',
        'only',
    ];

    public function getNodeType(): string
    {
        return Node\Expr\StaticCall::class;
    }

    /**
     * @param Node\Expr\StaticCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (join('\\', $node->class->parts) !== Route::class) {
            return [];
        }

        if (! in_array($node->name->name, $this->resourceMethods)) {
            return [];
        }

        if (in_array($node->getAttributes()['next']->name, $this->partialMethods)) {
            return [$this->errorFor($node->getAttributes()['next']->name)];
        }

        return [];
    }

    private function errorFor(string $method): RuleError
    {
        return RuleErrorBuilder::message(
            "Usage of [{$method}] method on route resource is disallowed. Please split the resource into multiple routes."
        )->build();
    }
}
