<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan\Laravel\Migrations;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\NodeVisitorAbstract;
use PHPStan\Rules\RuleErrorBuilder;

class WithoutTimestampsVisitor extends NodeVisitorAbstract
{
    private array $contextStack = [];

    public array $errors = [];

    public function enterNode(Node $node)
    {
        // Track context for 'withoutTimestamps' method calls
        if ($this->isWithoutTimestampsCall($node)) {
            $this->contextStack[] = 'withoutTimestamps';
        } else {
            $this->contextStack[] = null;
        }

        if ($this->isUpdateOrInsertCall($node)) {
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
            && in_array($node->name->name, ['update', 'insert', 'save', 'saveQuietly', 'create'], true);
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
                : ($currentNode instanceof StaticCall ? $currentNode->class : null);
        }

        return false;
    }
}
