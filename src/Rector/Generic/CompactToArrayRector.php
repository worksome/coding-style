<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Rector\Generic;

use PhpParser\Node;
use PhpParser\Node\ArrayItem;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use Rector\PHPStan\ScopeFetcher;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Unlike Rector's `CompactToVariablesRector`, this keeps every argument (including mixed string and array arguments).
 *
 * The call is left unchanged when any name cannot be resolved statically, is not a variable that is always defined at
 * the call site (as `compact()` omits undefined variables), or is a superglobal (which `compact()` cannot read
 * inside a function).
 */
class CompactToArrayRector extends AbstractRector
{
    private const array UNSUPPORTED_NAMES = [
        'this',
        'GLOBALS',
        '_SERVER',
        '_GET',
        '_POST',
        '_FILES',
        '_COOKIE',
        '_SESSION',
        '_REQUEST',
        '_ENV',
    ];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace `compact()` calls with an explicit array.',
            [
                new CodeSample(
                    "return compact('checkout', ['form']);",
                    "return ['checkout' => \$checkout, 'form' => \$form];",
                ),
            ]
        );
    }

    /** {@inheritdoc} */
    public function getNodeTypes(): array
    {
        return [FuncCall::class];
    }

    /** @param FuncCall $node */
    public function refactor(Node $node): Array_|null
    {
        if (! $this->isName($node, 'compact') || $node->isFirstClassCallable()) {
            return null;
        }

        $names = [];

        foreach ($node->getArgs() as $arg) {
            if ($arg->unpack || $arg->name !== null || ! $this->collectNames($arg->value, $names)) {
                return null;
            }
        }

        if ($names === []) {
            return null;
        }

        $scope = ScopeFetcher::fetch($node);

        foreach ($names as $name) {
            if (! $this->isAlwaysDefinedVariable($scope, $name)) {
                return null;
            }
        }

        return new Array_(array_map(
            fn (string $name): ArrayItem => new ArrayItem(new Variable($name), new String_($name)),
            array_values(array_unique($names)),
        ));
    }

    private function isAlwaysDefinedVariable(Scope $scope, string $name): bool
    {
        if (in_array($name, self::UNSUPPORTED_NAMES, true)) {
            return false;
        }

        if (preg_match('/\A[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*\z/', $name) !== 1) {
            return false;
        }

        return $scope->hasVariableType($name)->yes();
    }

    /**
     * Collect the variable names from a `compact()` argument, which may be a string or a (nested) array of strings.
     *
     * @param list<string> $names
     */
    private function collectNames(Expr $expr, array &$names): bool
    {
        if ($expr instanceof String_) {
            $names[] = $expr->value;

            return true;
        }

        if (! $expr instanceof Array_) {
            return false;
        }

        foreach ($expr->items as $item) {
            if ($item === null || $item->unpack || $item->key !== null || ! $this->collectNames($item->value, $names)) {
                return false;
            }
        }

        return true;
    }
}
