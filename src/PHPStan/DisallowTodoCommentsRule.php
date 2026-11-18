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
            // `yield from` is a single token, so comments between the two keywords are part of its text.
            if (! $token->is([T_COMMENT, T_DOC_COMMENT, T_YIELD_FROM])) {
                continue;
            }

            foreach (preg_split('/\r\n|\r|\n/', $token->text) ?: [] as $offset => $line) {
                // Only the whole word counts, so words such as "Mastodon" and the rule's own identifier (used in
                // `@phpstan-ignore` comments) are not reported.
                if (preg_match('/\btodos?\b/i', $line) !== 1) {
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
