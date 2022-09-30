<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Stmt>
 */
final class DisallowTodoCommentsRule implements Rule
{
    public function getNodeType(): string
    {
        return Stmt::class;
    }

    /**
     * @param Stmt $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $comments = $node->getComments();

        if ($comments === []) {
            return [];
        }

        $errors = [];

        foreach ($comments as $comment) {
            $text = $comment->getText();

            if (str_contains($text, 'TODO') || str_contains($text, '@todo')) {
                $errors[] = RuleErrorBuilder::message(
                    "Comments with TODO are disallowed."
                )->build();
            }
        }

        return $errors;
    }
}
