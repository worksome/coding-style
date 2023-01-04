<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan\Laravel\DisallowEnvironmentCheck;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\CallLike;
use PHPStan\Type\ObjectType;

final class DisallowEnvironmentCheckRule implements Rule
{
    private const METHOD_NAME = 'environment';

    public function getNodeType(): string
    {
        return CallLike::class;
    }

    /**
     * @param CallLike $node
     * @return array<RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node instanceof MethodCall && ! $node instanceof StaticCall) {
            return [];
        }

        if ($node->name->toLowerString() !== self::METHOD_NAME) {
            return [];
        }

        return match($node::class) {
            Node\Expr\MethodCall::class => $this->checkMethodCall($node->var, $scope),
            Node\Expr\StaticCall::class => $this->checkFacade($node->class),
            default => [],
        };
    }

    private function checkMethodCall(Node\Expr $node, Scope $scope): array
    {
        if ($node instanceof Node\Expr\FuncCall) {
            return $this->checkGlobalAppHelper($node);
        }

        if ($node instanceof Node\Expr\Variable) {
            return $this->checkAppVariable($node, $scope);
        }

        return [];
    }

    private function checkGlobalAppHelper(Node\Expr\FuncCall $node): array
    {
        return $node->name->toLowerString() === 'app' ? [$this->error()] : [];
    }

    private function checkAppVariable(Node\Expr\Variable $node, Scope $scope): array
    {
        $nativeType = $scope->getNativeType($node);

        if (! $nativeType instanceof ObjectType) {
            return [];
        }

        if ($nativeType->getClassName() === 'Illuminate\Contracts\Foundation\Application') {
            return [$this->error()];
        }

        if ($nativeType->getClassName() === 'Illuminate\Foundation\Application') {
            return [$this->error()];
        }

        return [];
    }

    private function checkFacade(Node\Name|Node\Expr $var): array
    {
        if (! $var instanceof Node\Name) {
            return [];
        }

        if (in_array($var->toCodeString(), ['\Illuminate\Support\Facades\App', '\App'])) {
            return [$this->error()];
        }

        return [];
    }

    private function error(): RuleError
    {
        return RuleErrorBuilder
            ::message('Environment checks are disallowed. Please use the driver pattern instead.')
            ->build();
    }
}
