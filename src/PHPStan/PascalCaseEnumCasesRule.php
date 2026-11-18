<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PHPStan;

use PhpParser\Node;
use PhpParser\Node\Stmt\EnumCase;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Worksome\CodingStyle\Utility;

/**
 * @implements Rule<EnumCase>
 */
class PascalCaseEnumCasesRule implements Rule
{
    public function getNodeType(): string
    {
        return EnumCase::class;
    }

    /**
     * @param EnumCase $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $caseName = $node->name->toString();

        if ($caseName === Utility::studly($caseName)) {
            return [];
        }

        return [
            RuleErrorBuilder::message("Enum case [{$caseName}] must be PascalCase.")
                ->identifier('worksome.pascalCaseEnumCases')
                ->build(),
        ];
    }
}
