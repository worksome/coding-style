<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\PhpCsFixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\ParserException;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\PhpDocParser\ParserConfig;
use SplFileInfo;
use const T_DOC_COMMENT;

class PropertyDollarSignFixer implements FixerInterface
{
    private Lexer $lexer;

    private TypeParser $typeParser;

    public function __construct()
    {
        $config = new ParserConfig([]);

        $this->lexer = new Lexer($config);
        $this->typeParser = new TypeParser($config, new ConstExprParser($config));
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'All `@property` variables must start with a dollar symbol.',
            [new CodeSample("<?php\n/**\n * @property string foo\n */\nclass Bar {}\n")]
        );
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = $tokens->count() - 1; $index > 0; $index--) {
            if (! $tokens[$index]->isGivenKind(T_DOC_COMMENT)) {
                continue;
            }

            $content = $tokens[$index]->getContent();

            $newContent = Preg::replaceCallback(
                // The lookahead captures a following line (after any blank lines) that continues the type (e.g. `*     |Bar $value`).
                '/^(\h*(?:\/\*\*|\*)\h*@property(?:-read|-write)?\h+)(.*?)(\h*(?:\*\/)?\h*)$(?=((?:\R\h*\*?\h*$)*\R\h*\*?\h*[|&<>,()\[\]{}:])?)/m',
                fn (array $matches): string => $matches[1]
                    . $this->fixPropertyDetail($matches[2], ($matches[4] ?? '') !== '')
                    . $matches[3],
                $content,
            );

            if ($newContent === $content) {
                continue;
            }

            $tokens[$index] = new Token([T_DOC_COMMENT, $newContent]);
        }
    }

    /**
     * Add a dollar sign to the property name in the detail of a `@property` tag (the type, name and description).
     *
     * The detail is returned unchanged when the property name cannot be identified unambiguously.
     */
    private function fixPropertyDetail(string $detail, bool $typeMayContinue): string
    {
        $tokens = new TokenIterator($this->lexer->tokenize($detail));

        if ($tokens->isCurrentTokenType(Lexer::TOKEN_VARIABLE)) {
            return $detail;
        }

        try {
            $type = $this->typeParser->parse($tokens);
        } catch (ParserException) {
            return $detail;
        }

        $tokens->tryConsumeTokenType(Lexer::TOKEN_HORIZONTAL_WS);

        // A tag with only a name and no type, such as `@property foo`.
        // If the next line may continue the type (e.g. `*     |Bar $value`), the first line has no name to fix.
        if ($tokens->isCurrentTokenType(Lexer::TOKEN_END)) {
            return ! $typeMayContinue && $type instanceof IdentifierTypeNode && Preg::match('/^\w+$/', $detail)
                ? '$' . $detail
                : $detail;
        }

        if (
            ! $tokens->isCurrentTokenType(Lexer::TOKEN_IDENTIFIER)
            || ! Preg::match('/^\w+$/', $tokens->currentTokenValue())
        ) {
            return $detail;
        }

        $offset = $tokens->currentTokenOffset();

        return substr($detail, 0, $offset) . '$' . substr($detail, $offset);
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(T_DOC_COMMENT);
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return 'Worksome/property_dollar_sign';
    }

    public function getPriority(): int
    {
        return 0;
    }

    public function supports(SplFileInfo $file): bool
    {
        return true;
    }
}
