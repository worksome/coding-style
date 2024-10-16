<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan\Laravel\Migrations;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\NodeVisitorAbstract;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

class WithoutTimestampsVisitor extends NodeVisitorAbstract
{
    private const WITHOUT_TIMESTAMPS_METHOD = 'withoutTimestamps';

    private array $contextStack = [];

    public array $errors = [];

    private Scope $scope;

    public function __construct(Scope $scope)
    {
        $this->scope = $scope;
    }

    public function enterNode(Node $node): void
    {
        $this->contextStack[] = $this->isWithoutTimestampsCall($node) ? self::WITHOUT_TIMESTAMPS_METHOD : null;

        if (! $this->isUpdateOrInsertCall($node)) {
            return;
        }

        if (! $this->isModelCall($node)) {
            return;
        }

        if ($this->isWithinWithoutTimestampsContext() || $this->hasWithoutTimestampsChain($node)) {
            return;
        }

        $this->errors[] = RuleErrorBuilder::message(
            sprintf(
                "Line %d: The '%s()' method call should be within 'withoutTimestamps()' context to prevent unintended timestamp updates.",
                $node->getLine(),
                $node->name->name
            )
        )->line($node->getLine())
            ->identifier('worksome.laravel.requireWithoutTimestamps')
            ->build();
    }

    public function leaveNode(Node $node): void
    {
        array_pop($this->contextStack);
    }

    private function isWithoutTimestampsCall(Node $node): bool
    {
        return ($node instanceof MethodCall || $node instanceof StaticCall)
            && $node->name instanceof Node\Identifier
            && $node->name->name === self::WITHOUT_TIMESTAMPS_METHOD;
    }

    private function isUpdateOrInsertCall(Node $node): bool
    {
        return ($node instanceof MethodCall || $node instanceof StaticCall)
            && $node->name instanceof Node\Identifier
            && in_array(
                $node->name->name,
                RequireWithoutTimestampsRule::TIMESTAMP_MODIFYING_METHODS,
                true
            );
    }

    private function isWithinWithoutTimestampsContext(): bool
    {
        return in_array(self::WITHOUT_TIMESTAMPS_METHOD, $this->contextStack);
    }

    private function hasWithoutTimestampsChain(Node $node): bool
    {
        $currentNode = $node;

        while ($currentNode instanceof MethodCall || $currentNode instanceof StaticCall) {
            if ($currentNode->name instanceof Node\Identifier
                && $currentNode->name->name === self::WITHOUT_TIMESTAMPS_METHOD) {
                return true;
            }

            $currentNode = $currentNode instanceof MethodCall
                ? $currentNode->var
                : $currentNode->class;
        }

        return false;
    }

    private function isModelCall(Node $node): bool
    {
        if (! $node instanceof MethodCall && ! $node instanceof StaticCall) {
            return false;
        }

        if ($node instanceof MethodCall) {
            $varType = $this->scope->getType($node->var);

            $modelType = new ObjectType(Model::class);

            return $varType->isSuperTypeOf($modelType)->yes();
        }

        if (! $node instanceof StaticCall || ! $node->class instanceof Node\Name) {
            return false;
        }

        $className = $this->scope->resolveName($node->class);

        if (! $className) {
            return false;
        }

        $modelType = new ObjectType(Model::class);
        $classType = new ObjectType($className);

        return $classType->isSubclassOf($modelType)->yes();
    }
}
