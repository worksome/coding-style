<?php

declare(strict_types=1);

namespace Worksome\CodingStyle;

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\MethodDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\CommentedOutCodeSniff;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedTypesFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NullableTypeDeclarationFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryToElvisOperatorFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\TypeDeclarationSpacesFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;
use SlevomatCodingStandard\Sniffs\Classes\ModernClassNameReferenceSniff;
use SlevomatCodingStandard\Sniffs\Classes\RequireMultiLineMethodSignatureSniff;
use SlevomatCodingStandard\Sniffs\Commenting\ForbiddenAnnotationsSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireMultiLineConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireMultiLineTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\Functions\RequireMultiLineCallSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\DisallowGroupUseSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\RequireOneNamespaceInFileSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\UselessConstantTypeHintSniff;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\Configuration\ECSConfigBuilder;
use Worksome\CodingStyle\PhpCsFixer\DisallowParamNoTypeOrCommentFixer;
use Worksome\CodingStyle\PhpCsFixer\PropertyDollarSignFixer;
use Worksome\CodingStyle\PhpCsFixer\SpaceInGenericsFixer;

class WorksomeEcsConfig
{
    public static function configure(): ECSConfigBuilder
    {
        return ECSConfig::configure()
            ->withPreparedSets(psr12: true)
            ->withConfiguredRule(RequireMultiLineTernaryOperatorSniff::class, [
                'lineLengthLimit' => 120,
            ])
            ->withConfiguredRule(CommentedOutCodeSniff::class, [
                'maxPercentage' => 70,
            ])
            ->withConfiguredRule(PhpdocAlignFixer::class, [
                'align' => PhpdocAlignFixer::ALIGN_VERTICAL,
            ])
            ->withConfiguredRule(OrderedImportsFixer::class, [
                'imports_order' => [
                    OrderedImportsFixer::IMPORT_TYPE_CLASS,
                    OrderedImportsFixer::IMPORT_TYPE_FUNCTION,
                    OrderedImportsFixer::IMPORT_TYPE_CONST,
                ],
                'sort_algorithm' => OrderedImportsFixer::SORT_ALPHA,
            ])
            ->withConfiguredRule(OperatorLinebreakFixer::class, [
                'only_booleans' => true,
            ])
            ->withConfiguredRule(ForbiddenFunctionsSniff::class, [
                'forbiddenFunctions' => [
                    'dd' => null,
                    'dump' => null,
                    'var_dump' => null,
                    'ddd' => null,
                    'ray' => null,
                ],
            ])
            ->withConfiguredRule(ForbiddenAnnotationsSniff::class, [
                'forbiddenAnnotations' => [
                    '@package',
                    '@author',
                    '@created',
                    '@version',
                    '@copyright',
                    '@license',
                    '@inheritDoc',
                ],
            ])
            ->withConfiguredRule(LineLengthFixer::class, [
                LineLengthFixer::INLINE_SHORT_LINES => false,
            ])
            ->withConfiguredRule(BinaryOperatorSpacesFixer::class, [
                'operators' => [
                    '=>' => null,
                    '|' => 'no_space',
                ],
            ])
            ->withConfiguredRule(NullableTypeDeclarationFixer::class, [
                'syntax' => 'union',
            ])
            ->withConfiguredRule(OrderedTypesFixer::class, [
                'null_adjustment' => 'always_last',
                'sort_algorithm' => 'none',
            ])
            ->withConfiguredRule(UnaryOperatorSpacesFixer::class, [
                'only_dec_inc' => true,
            ])
            ->withConfiguredRule(TrailingCommaInMultilineFixer::class, [
                'elements' => [
                    TrailingCommaInMultilineFixer::ELEMENTS_ARRAYS,
                    TrailingCommaInMultilineFixer::ELEMENTS_PARAMETERS,
                ],
            ])
            ->withRules([
                CastSpacesFixer::class,
                NotOperatorWithSuccessorSpaceFixer::class,
                TernaryToElvisOperatorFixer::class,
                TypeDeclarationSpacesFixer::class,
                RequireMultiLineConditionSniff::class,
                RequireMultiLineCallSniff::class,
                RequireMultiLineMethodSignatureSniff::class,
                SpaceInGenericsFixer::class,
                PhpdocSeparationFixer::class,
                RequireOneNamespaceInFileSniff::class,
                ArraySyntaxFixer::class,
                ListSyntaxFixer::class,
                NoEmptyCommentFixer::class,
                NoEmptyPhpdocFixer::class,
                MethodDeclarationSniff::class,
                LineEndingFixer::class,
                SingleTraitInsertPerStatementFixer::class,
                ShortScalarCastFixer::class,
                UselessConstantTypeHintSniff::class,
                NoUnneededImportAliasFixer::class,
                NoEmptyStatementFixer::class,
                ModernClassNameReferenceSniff::class,
                DisallowGroupUseSniff::class,
                ClassDefinitionFixer::class,
                NoUnusedImportsFixer::class,
                DisallowParamNoTypeOrCommentFixer::class,
                PropertyDollarSignFixer::class,
                TypesSpacesFixer::class,
                SingleQuoteFixer::class,
                BlankLineBeforeStatementFixer::class,
                ClassAttributesSeparationFixer::class,
                PhpdocNoUselessInheritdocFixer::class,
                PhpdocTrimFixer::class,
                StandardizeNotEqualsFixer::class,
            ]);
    }
}
