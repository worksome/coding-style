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
        if (! $node instanceof Node\Expr\StaticCall) {
            return [];
        }

        if ($node->class->toString() !== Route::class) {
            return [];
        }

        if (! in_array($node->name->name, $this->resourceMethods)) {
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

    private function errorFor(string $method): RuleError
    {
        return RuleErrorBuilder::message(
            "Usage of [{$method}] method on route resource is disallowed. Please split the resource into multiple routes."
        )->build();
    }
}
