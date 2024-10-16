<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan\Laravel\Migrations;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;
use Illuminate\Database\Eloquent\Model;

class WithoutTimestampsVisitor extends NodeVisitorAbstract
{
    private array $contextStack = [];

    public array $errors = [];

    private Scope $scope;

    public function __construct(Scope $scope)
    {
        $this->scope = $scope;
    }

    public function enterNode(Node $node): void
    {
        if ($this->isWithoutTimestampsCall($node)) {
            $this->contextStack[] = 'withoutTimestamps';
        } else {
            $this->contextStack[] = null;
        }

        if ($this->isUpdateOrInsertCall($node) && $this->isModelCall($node)) {
            if (! $this->isWithinWithoutTimestampsContext() && ! $this->hasWithoutTimestampsChain($node)) {
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
        }
    }

    public function leaveNode(Node $node): void
    {
        array_pop($this->contextStack);
    }

    private function isWithoutTimestampsCall(Node $node): bool
    {
        return ($node instanceof MethodCall || $node instanceof StaticCall)
            && $node->name instanceof Node\Identifier
            && $node->name->name === 'withoutTimestamps';
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
        return in_array('withoutTimestamps', $this->contextStack);
    }

    private function hasWithoutTimestampsChain(Node $node): bool
    {
        $currentNode = $node;

        while ($currentNode instanceof MethodCall || $currentNode instanceof StaticCall) {
            if ($currentNode->name instanceof Node\Identifier
                && $currentNode->name->name === 'withoutTimestamps') {
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
        if ($node instanceof MethodCall) {
            $varType = $this->scope->getType($node->var);

            $modelType = new ObjectType(Model::class);

            if ($varType->isSuperTypeOf($modelType)->yes()) {
                return true;
            }
        } elseif ($node instanceof StaticCall) {
            if ($node->class instanceof Node\Name) {
                $className = $this->scope->resolveName($node->class);

                if ($className) {
                    $modelType = new ObjectType(Model::class);
                    $classType = new ObjectType($className);

                    if ($classType->isSubclassOf($modelType)->yes()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
