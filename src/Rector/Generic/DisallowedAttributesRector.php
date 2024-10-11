<?php

namespace Worksome\CodingStyle\Rector\Generic;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class DisallowedAttributesRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var array<class-string> */
    private array $disallowedAttributes = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove attributes which are not allowed.',
            [
                new CodeSample(
                    <<<PHP
                    #[NotAllowed]
                    class MyClass {}
                    PHP,
                    'class MyClass {}',
                )
            ]
        );
    }

    /** {@inheritdoc} */
    public function getNodeTypes(): array
    {
        return [Node\AttributeGroup::class];
    }

    /** {@inheritdoc} */
    public function configure(array $configuration): void
    {
        $this->disallowedAttributes = $configuration;
    }

    /** @param Node\AttributeGroup $node */
    public function refactor(Node $node)
    {
        foreach ($node->attrs as $key => $attribute) {
            if (! $this->isNames($attribute, $this->disallowedAttributes)) {
                continue;
            }

            unset($node->attrs[$key]);
        }

        if ($node->attrs === []) {
            return NodeTraverser::REMOVE_NODE;
        }

        return null;
    }
}
