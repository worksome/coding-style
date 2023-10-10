<?php

namespace Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource;

use PhpParser\Node;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use Worksome\CodingStyle\Enums\AttributeKey;

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

    public function isApplicable(Node $node): bool
    {
        if (! $node instanceof Node\Expr\CallLike) {
            return false;
        }

        if (! property_exists($node, 'name')) {
            return false;
        }

        if (! property_exists($node->name, 'name')) {
            return false;
        }

        if (! in_array($node->name->name, $this->resourceMethods)) {
            return false;
        }

        return true;
    }

    public function inspect(Node $node): array
    {
        $next = $node->getAttribute(AttributeKey::Next->value);

        while ($next !== null) {
            if (in_array($next->name, $this->partialMethods)) {
                return [$this->errorFor($next->name)];
            }

            $next = $next->getAttribute(AttributeKey::Parent->value)->getAttribute(AttributeKey::Next->value);
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
