<?php

namespace Worksome\CodingStyle\PHPStan\Laravel;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FuncCall>
 */
class DisallowAppHelperUsageRule implements Rule
{
    const FUNCTION_NAME = 'app';

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    /**
     * @param FuncCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $nodeName = $node->name;

        if (!$nodeName instanceof Node\Name) {
            return [];
        }

        $functionName = $nodeName->toString();

        if ($functionName !== self::FUNCTION_NAME) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                "Usage of app helper is disallowed. Use dependency injection instead."
            )->build(),
        ];
    }
}