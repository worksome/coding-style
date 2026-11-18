<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\FileNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PhpToken;

/**
 * Comments are tokenised from the file directly, as comments that are not attached to an AST node would otherwise be missed.
 *
 * @implements Rule<FileNode>
 */
class DisallowTodoCommentsRule implements Rule
{
    public function getNodeType(): string
    {
        return FileNode::class;
    }

    /**
     * @param FileNode $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $contents = @file_get_contents($scope->getFile());

        if ($contents === false || stripos($contents, 'todo') === false) {
            return [];
        }

        $errors = [];

        foreach (PhpToken::tokenize($contents) as $token) {
            if (! $token->is([T_COMMENT, T_DOC_COMMENT])) {
                continue;
            }

            foreach (explode("\n", $token->text) as $offset => $line) {
                if (stripos($line, 'todo') === false) {
                    continue;
                }

                $errors[] = RuleErrorBuilder::message('Comments with TODO are disallowed.')
                    ->identifier('worksome.disallowTodoComments')
                    ->line($token->line + $offset)
                    ->build();
            }
        }

        return $errors;
    }
}
