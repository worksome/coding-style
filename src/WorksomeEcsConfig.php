<?php

declare(strict_types=1);

namespace Worksome\CodingStyle;

use PHP_CodeSniffer\Standards\Generic\Sniffs\ControlStructures\InlineControlStructureSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseKeywordSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Files\EndFileNewlineSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\MethodDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\LowercaseDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\CommentedOutCodeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\LanguageConstructSpacingSniff;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;
use SlevomatCodingStandard\Sniffs\Classes\ClassConstantVisibilitySniff;
use SlevomatCodingStandard\Sniffs\Classes\ClassMemberSpacingSniff;
use SlevomatCodingStandard\Sniffs\Classes\EmptyLinesAroundClassBracesSniff;
use SlevomatCodingStandard\Sniffs\Classes\MethodSpacingSniff;
use SlevomatCodingStandard\Sniffs\Classes\ModernClassNameReferenceSniff;
use SlevomatCodingStandard\Sniffs\Classes\PropertyDeclarationSniff;
use SlevomatCodingStandard\Sniffs\Classes\PropertySpacingSniff;
use SlevomatCodingStandard\Sniffs\Classes\RequireMultiLineMethodSignatureSniff;
use SlevomatCodingStandard\Sniffs\Commenting\ForbiddenAnnotationsSniff;
use SlevomatCodingStandard\Sniffs\Commenting\UselessInheritDocCommentSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireMultiLineConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireMultiLineTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireShortTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\Functions\RequireMultiLineCallSniff;
use SlevomatCodingStandard\Sniffs\Functions\RequireTrailingCommaInDeclarationSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\DisallowGroupUseSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\NamespaceDeclarationSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\RequireOneNamespaceInFileSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSpacingSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSpacingSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\UselessConstantTypeHintSniff;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use Worksome\CodingStyle\PhpCsFixer\SpaceInGenericsFixer;
use Worksome\CodingStyle\Sniffs\Classes\ExceptionSuffixSniff;
use Worksome\CodingStyle\Sniffs\Comments\DisallowTodoCommentsSniff;
use Worksome\CodingStyle\Sniffs\Enums\PascalCasingEnumCasesSniff;
use Worksome\CodingStyle\Sniffs\Functions\DisallowCompactUsageSniff;
use Worksome\CodingStyle\Sniffs\Laravel\ConfigFilenameKebabCaseSniff;
use Worksome\CodingStyle\Sniffs\Laravel\DisallowBladeOutsideOfResourcesDirectorySniff;
use Worksome\CodingStyle\Sniffs\Laravel\DisallowEnvUsageSniff;
use Worksome\CodingStyle\Sniffs\Laravel\DisallowHasFactorySniff;
use Worksome\CodingStyle\Sniffs\Laravel\EventListenerSuffixSniff;
use Worksome\CodingStyle\Sniffs\PhpDoc\DisallowParamNoTypeOrCommentSniff;
use Worksome\CodingStyle\Sniffs\PhpDoc\PropertyDollarSignSniff;

class WorksomeEcsConfig
{
    public static function setup(ECSConfig $ecsConfig): void
    {
        $ecsConfig->sets([
            SetList::PSR_12,
        ]);

        $ecsConfig->skip(self::skips());

        $ecsConfig->ruleWithConfiguration(RequireMultiLineTernaryOperatorSniff::class, [
            'lineLengthLimit' => 120,
        ]);
        $ecsConfig->ruleWithConfiguration(CommentedOutCodeSniff::class, [
            'maxPercentage' => 70,
        ]);
        $ecsConfig->ruleWithConfiguration(PhpdocAlignFixer::class, [
            'align' => PhpdocAlignFixer::ALIGN_VERTICAL,
        ]);

        $ecsConfig->ruleWithConfiguration(OrderedImportsFixer::class, [
            'imports_order' => [
                OrderedImportsFixer::IMPORT_TYPE_CLASS,
                OrderedImportsFixer::IMPORT_TYPE_FUNCTION,
                OrderedImportsFixer::IMPORT_TYPE_CONST,
            ],
            'sort_algorithm' => OrderedImportsFixer::SORT_ALPHA,
        ]);
        $ecsConfig->ruleWithConfiguration(OperatorLinebreakFixer::class, [
            'only_booleans' => true,
        ]);
        $ecsConfig->ruleWithConfiguration(ForbiddenFunctionsSniff::class, [
            'forbiddenFunctions' => [
                'dd' => null,
                'dump' => null,
                'var_dump' => null,
                'ddd' => null,
                'ray' => null,
            ]
        ]);
        $ecsConfig->ruleWithConfiguration(EmptyLinesAroundClassBracesSniff::class, [
            'linesCountAfterOpeningBrace' => 0,
            'linesCountBeforeClosingBrace' => 0,
        ]);
        $ecsConfig->ruleWithConfiguration(ForbiddenAnnotationsSniff::class, [
            'forbiddenAnnotations' => [
                '@package',
                '@author',
                '@created',
                '@version',
                '@copyright',
                '@license',
                '@inheritDoc',
            ]
        ]);
        $ecsConfig->ruleWithConfiguration(LineLengthFixer::class, [
            LineLengthFixer::INLINE_SHORT_LINES => false,
        ]);

        $ecsConfig->ruleWithConfiguration(BinaryOperatorSpacesFixer::class, [
            'operators' => [
                '=>' => null,
            ],
        ]);

        $ecsConfig->rules([
            RequireMultiLineConditionSniff::class,
            RequireShortTernaryOperatorSniff::class,
            ReturnTypeHintSpacingSniff::class,
            RequireMultiLineCallSniff::class,
            SpaceAfterNotSniff::class,
            RequireMultiLineMethodSignatureSniff::class,
            RequireTrailingCommaInDeclarationSniff::class,
            SpaceInGenericsFixer::class,
            PhpdocSeparationFixer::class,
            RequireOneNamespaceInFileSniff::class,
            ArraySyntaxFixer::class,
            ListSyntaxFixer::class,
            NoEmptyCommentFixer::class,
            NoEmptyPhpdocFixer::class,
            EndFileNewlineSniff::class,
            NamespaceDeclarationSniff::class,
            MethodDeclarationSniff::class,
            LineEndingFixer::class,
            SingleTraitInsertPerStatementFixer::class,
            ShortScalarCastFixer::class,
            UselessConstantTypeHintSniff::class,
            NoUnneededImportAliasFixer::class,
            NoEmptyStatementFixer::class,
            ModernClassNameReferenceSniff::class,
            ClassConstantVisibilitySniff::class,
            PropertyDeclarationSniff::class,
            ParameterTypeHintSpacingSniff::class,
            DisallowGroupUseSniff::class,
            UselessInheritDocCommentSniff::class,
            SpaceAfterCastSniff::class,
            ClassDefinitionFixer::class,
            LowercaseDeclarationSniff::class,
            InlineControlStructureSniff::class,
            LowerCaseKeywordSniff::class,
            LanguageConstructSpacingSniff::class,
            MethodSpacingSniff::class,
            PropertySpacingSniff::class,
            ClassMemberSpacingSniff::class,
            NoUnusedImportsFixer::class,
            ExceptionSuffixSniff::class,
            DisallowTodoCommentsSniff::class,
            DisallowCompactUsageSniff::class,
            ConfigFilenameKebabCaseSniff::class,
            DisallowBladeOutsideOfResourcesDirectorySniff::class,
            DisallowEnvUsageSniff::class,
            DisallowHasFactorySniff::class,
            EventListenerSuffixSniff::class,
            DisallowParamNoTypeOrCommentSniff::class,
            PropertyDollarSignSniff::class,
            TypesSpacesFixer::class,
            PascalCasingEnumCasesSniff::class,
        ]);
    }

    public static function skips(array $additional = []): array
    {
        return [
            FunctionDeclarationFixer::class,
            UnaryOperatorSpacesFixer::class,
            ...$additional,
        ];
    }
}
