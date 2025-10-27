<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Rector\Laravel;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class DisallowedLegacyCollectionArraySyntaxRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'PHPDoc `Collection` types must not use the legacy array syntax.',
            [
                new CodeSample(
                    <<<PHP
                    /** @property Collection|Model[] \$models */
                    class MyClass {}
                    PHP,
                    <<<PHP
                    /** @property Collection<int, Model> \$models */
                    class MyClass {}
                    PHP,
                ),
            ]
        );
    }

    /** {@inheritdoc} */
    public function getNodeTypes(): array
    {
        return [Property::class, ClassMethod::class, Class_::class];
    }

    /** {@inheritdoc} */
    public function refactor(Node $node): Node|null
    {
        $docComment = $node->getDocComment();

        if (null === $docComment) {
            return null;
        }

        $originalText = $docComment->getText();
        $transformedText = $this->transformDocComment($originalText);

        if ($originalText === $transformedText) {
            return null;
        }

        $node->setDocComment(new Doc($transformedText));

        return $node;
    }

    protected function transformDocComment(string $docComment): string
    {
        return preg_replace(
            pattern: '#(\\\\?(?:Illuminate\\\\Database\\\\Eloquent\\\\)?Collection)\|([^\s\[\]]+)\[]#',
            replacement: '$1<int, $2>',
            subject: $docComment
        );
    }
}
