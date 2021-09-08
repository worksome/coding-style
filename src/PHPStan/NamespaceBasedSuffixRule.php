<?php

namespace Worksome\CodingStyle\PHPStan;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Class_>
 */
class NamespaceBasedSuffixRule implements Rule
{
    /**
     * @param array<string, string> $namespaceAndSuffix
     */
    public function __construct(
        private array $namespaceAndSuffix,
    ) {}

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $fullyQualifiedNameSpace = $node->namespacedName->toString();


        foreach ($this->namespaceAndSuffix as $nameSpace => $suffix) {
            if (! str_starts_with($fullyQualifiedNameSpace, $nameSpace)) {
                continue;
            }

            if (str_ends_with($fullyQualifiedNameSpace, $suffix)) {
                continue;
            }

            return [
                RuleErrorBuilder::message(
                    "Classes in namespace $nameSpace should always be suffixed with $suffix."
                )->build(),
            ];
        }

        return [];
    }
}