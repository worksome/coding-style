<?php

namespace Worksome\CodingStyle\Rector\Generic;

use Illuminate\Support\Collection;
use PhpParser\Node;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class DisallowedAttributesRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var array<class-string>  */
    private array $disallowedAttributes = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove attributes which are not allowed.', [
                new CodeSample(
                    <<<PHP
                    #[NotAllowed]
                    class MyClass {}
                    PHP,
                    "class MyClass {}",
                )
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [Node\AttributeGroup::class];
    }

    public function configure(array $configuration) : void
    {
        $this->disallowedAttributes = $configuration;
    }

    /**
     * @param Node\AttributeGroup $node
     */
    public function refactor(Node $node)
    {
        Collection::make($node->attrs)->reject(function (Node\Attribute $node) {
            foreach ($this->disallowedAttributes as $disallowedAttribute) {
                if ($this->isName($node, $disallowedAttribute)) {
                    $this->removeNode($node);
                    return true;
                }
            }
            return false;
        })->whenEmpty(fn() => $this->removeNode($node));
    }
}
