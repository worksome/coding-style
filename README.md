# Worksome Coding Style

[![Latest Stable Version](https://img.shields.io/packagist/v/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)
[![Total Downloads](https://img.shields.io/packagist/dt/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)
[![Latest Unstable Version](https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square)](https://packagist.org/packages/worksome/coding-style#dev-main)
[![License](https://img.shields.io/packagist/l/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)

This repository contains the coding style followed by Worksome.

It includes configuration for [ECS](https://github.com/symplify/easy-coding-standard), [PHPStan](https://phpstan.org), and [Rector](https://getrector.org).

## Setup

Install this Composer package:

```
composer require --dev worksome/coding-style
```

Run the generate command for generating the config files:

```
composer generate-coding-style-stubs
```

Add the following section to your `composer.json` file:

```json
"scripts": {
    "ecs": "vendor/bin/ecs",
    "ecs:fix": "vendor/bin/ecs --fix",
    "phpstan": "vendor/bin/phpstan analyse",
    "rector": "vendor/bin/rector process --dry-run --ansi",
    "rector:fix": "vendor/bin/rector process --ansi"
},
```

## Usage

To use it, simply run one of the scripts added to composer.

```
$ composer ecs
$ composer ecs:fix
$ composer phpstan
$ composer rector
$ composer rector:fix
```

## ECS Rules

The Worksome code style extends the [PSR-12 base rule set](https://php-fig.org/psr/psr-12).

### Excluded / Skipped Rules

- [`UnaryOperatorSpacesFixer`](https://cs.symfony.com/doc/rules/operator/unary_operator_spaces.html)

### Additional / Customised Rules

> **Note:** Customised rules have a ⚙️ icon.

#### [PhpCsFixer](https://cs.symfony.com)

- [`ArraySyntaxFixer`](https://cs.symfony.com/doc/rules/array_notation/array_syntax.html)
- [`BinaryOperatorSpacesFixer` ⚙️](https://cs.symfony.com/doc/rules/operator/binary_operator_spaces.html)
- [`BlankLineBeforeStatementFixer` ⚙️](https://cs.symfony.com/doc/rules/whitespace/blank_line_before_statement.html)
- [`ClassAttributesSeparationFixer`](https://cs.symfony.com/doc/rules/class_notation/class_attributes_separation.html)
- [`ClassDefinitionFixer`](https://cs.symfony.com/doc/rules/class_notation/class_definition.html)
- [`LineEndingFixer`](https://cs.symfony.com/doc/rules/whitespace/line_ending.html)
- [`ListSyntaxFixer`](https://cs.symfony.com/doc/rules/list_notation/list_syntax.html)
- [`NoEmptyCommentFixer`](https://cs.symfony.com/doc/rules/comment/no_empty_comment.html)
- [`NoEmptyPhpdocFixer`](https://cs.symfony.com/doc/rules/phpdoc/no_empty_phpdoc.html)
- [`OperatorLinebreakFixer` ⚙️](https://cs.symfony.com/doc/rules/operator/operator_linebreak.html)
- [`OrderedImportsFixer` ⚙️](https://cs.symfony.com/doc/rules/import/ordered_imports.html)
- [`PhpdocAlignFixer` ⚙️](https://cs.symfony.com/doc/rules/phpdoc/phpdoc_align.html)
- [`PhpdocNoUselessInheritdocFixer`](https://cs.symfony.com/doc/rules/phpdoc/phpdoc_no_useless_inheritdoc.html)
- [`PhpdocSeparationFixer`](https://cs.symfony.com/doc/rules/phpdoc/phpdoc_separation.html)
- [`PhpdocTrimFixer`](https://cs.symfony.com/doc/rules/phpdoc/phpdoc_trim.html)
- [`SingleQuoteFixer`](https://cs.symfony.com/doc/rules/string_notation/single_quote.html)
- [`SingleTraitInsertPerStatementFixer`](https://cs.symfony.com/doc/rules/class_notation/single_trait_insert_per_statement.html)
- [`ShortScalarCastFixer`](https://cs.symfony.com/doc/rules/cast_notation/short_scalar_cast.html)
- [`StandardizeNotEqualsFixer`](https://cs.symfony.com/doc/rules/operator/standardize_not_equals.html)
- [`NoEmptyStatementFixer`](https://cs.symfony.com/doc/rules/semicolon/no_empty_statement.html)
- [`NoUnneededImportAliasFixer`](https://cs.symfony.com/doc/rules/import/no_unneeded_import_alias.html)
- [`NoUnusedImportsFixer`](https://cs.symfony.com/doc/rules/import/no_unused_imports.html)
- [`TrailingCommaInMultilineFixer`](https://cs.symfony.com/doc/rules/control_structure/trailing_comma_in_multiline.html)
- [`TypesSpacesFixer`](https://cs.symfony.com/doc/rules/whitespace/types_spaces.html)

#### [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

- [`CommentedOutCodeSniff` ⚙️](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Customisable-Sniff-Properties#squizphpcommentedoutcode)
- [`ForbiddenFunctionsSniff` ⚙️](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Customisable-Sniff-Properties#genericphpforbiddenfunctions)
- [`SpaceAfterNotSniff`](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/Formatting/SpaceAfterNotSniff.php)
- [`EndFileNewlineSniff`](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/PSR2/Sniffs/Files/EndFileNewlineSniff.php)
- [`MethodDeclarationSniff`](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/PSR2/Sniffs/Methods/MethodDeclarationSniff.php)
- [`SpaceAfterCastSniff`](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/Formatting/SpaceAfterCastSniff.php)
- [`LowercaseDeclarationSniff`](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Squiz/Sniffs/ControlStructures/LowercaseDeclarationSniff.php)
- [`InlineControlStructureSniff`](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/ControlStructures/InlineControlStructureSniff.php)
- [`LowerCaseKeywordSniff`](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/PHP/LowerCaseKeywordSniff.php)
- [`LanguageConstructSpacingSniff`](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Squiz/Sniffs/WhiteSpace/LanguageConstructSpacingSniff.php)

#### [Slevomat Coding Standard](https://github.com/slevomat/coding-standard)

- [`ClassConstantVisibilitySniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassesclassconstantvisibility-)
- [`ClassMemberSpacingSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassesclassmemberspacing-)
- [`DisallowGroupUseSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/namespaces.md#slevomatcodingstandardnamespacesdisallowgroupuse)
- [`EmptyLinesAroundClassBracesSniff` ⚙️](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassesemptylinesaroundclassbraces-)
- [`ForbiddenAnnotationsSniff` ⚙️](https://github.com/slevomat/coding-standard/blob/master/doc/commenting.md#slevomatcodingstandardcommentingforbiddenannotations-)
- [`MethodSpacingSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassesmethodspacing-)
- [`ModernClassNameReferenceSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassesmodernclassnamereference-)
- [`NamespaceDeclarationSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/namespaces.md#slevomatcodingstandardnamespacesnamespacedeclaration-)
- [`ParameterTypeHintSpacingSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/type-hints.md#slevomatcodingstandardtypehintsparametertypehintspacing-)
- [`PropertyDeclarationSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassespropertydeclaration-)
- [`PropertySpacingSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassespropertyspacing-)
- [`RequireMultiLineCallSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/functions.md#slevomatcodingstandardfunctionsrequiremultilinecall-)
- [`RequireMultiLineConditionSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/control-structures.md#slevomatcodingstandardcontrolstructuresrequiremultilinecondition-)
- [`RequireMultiLineMethodSignatureSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassesrequiremultilinemethodsignature-)
- [`RequireMultiLineTernaryOperatorSniff` ⚙️](https://github.com/slevomat/coding-standard/blob/master/doc/control-structures.md#slevomatcodingstandardcontrolstructuresrequiremultilineternaryoperator-)
- [`RequireOneNamespaceInFileSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/namespaces.md#slevomatcodingstandardnamespacesrequireonenamespaceinfile)
- [`RequireShortTernaryOperatorSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/control-structures.md#slevomatcodingstandardcontrolstructuresrequireshortternaryoperator-)
- [`RequireTrailingCommaInDeclarationSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/functions.md#slevomatcodingstandardfunctionsrequiretrailingcommaindeclaration-)
- [`ReturnTypeHintSpacingSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/type-hints.md#slevomatcodingstandardtypehintsreturntypehintspacing-)
- [`UselessConstantTypeHintSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/type-hints.md#slevomatcodingstandardtypehintsuselessconstanttypehint-)
- [`UselessInheritDocCommentSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/commenting.md#slevomatcodingstandardcommentinguselessinheritdoccomment-)

#### [Symplify Coding Standard](https://github.com/symplify/coding-standard)

- [`LineLengthFixer` ⚙️](https://github.com/symplify/coding-standard/blob/main/docs/rules_overview.md#linelengthfixer)

#### [Worksome](src)

- [`ConfigFilenameKebabCaseSniff`](#config-filename-kebab-case)
- [`DisallowBladeOutsideOfResourcesDirectorySniff`](#disallow-blade-outside-the-resources-directory)
- [`DisallowCompactUsageSniff`](#disallow-compact-usage)
- [`DisallowEnvUsageSniff`](#disallow-env-usage)
- [`DisallowHasFactorySniff`](#disallow-hasfactory-usage)
- [`DisallowParamNoTypeOrCommentSniff`](#param-tags-with-no-type-or-comment)
- [`DisallowTodoCommentsSniff`](#disallow-todo-comments)
- [`EventListenerSuffixSniff`](#event-listener-suffix)
- [`ExceptionSuffixSniff`](#exception-suffix)
- [`PropertyDollarSignSniff`](#property-dollar-sign)
- [`PascalCasingEnumCasesSniff`](#pascal-casing-enum-cases)
- [`SpaceInGenericsFixer`](#space-in-generics)

## Custom PHPStan rules

The Worksome code style includes the following custom PHPStan rules.

### Generic

Rules that are applied to all projects.

#### [`DeclareStrictTypes`](src/PHPStan/DeclareStrictTypesRule.php)

**Identifier:** `worksome.declareStrictTypes`

This rule is used to ensure that all PHP files include with the `declare(strict_types=1)` statement.

#### [`DisallowPHPUnit`](src/PHPStan/DisallowPHPUnitRule.php)

**Identifier:** `worksome.disallowPhpunit`

This rule prevents PHPUnit tests in favour of Pest PHP. It will allow abstract `TestCase` classes.

#### [`NamespaceBasedSuffix`](src/PHPStan/NamespaceBasedSuffixRule.php)

**Identifier:** `worksome.namespaceBasedSuffix`

Sets up configuration for suffixing the following namespaces

- `App\Events`: `Event`
- `App\Listener`: `Listener`
- `App\Policies`: `Policy`
- `App\Jobs`: `Job`

This makes sures events, listeners, policies and jobs has the same suffix.

### Laravel

Rules that are only applied in a Laravel context.

#### [`DisallowEnvironmentCheckRule`](src/PHPStan/Laravel/DisallowEnvironmentCheck/DisallowEnvironmentCheckRule.php)

**Identifier:** `worksome.laravel.disallowEnvironmentCheck`

This rule will prevent checking the application environment, instead preferring that a driver based approach is used.

#### [`DisallowPartialRouteFacadeResource`](src/PHPStan/Laravel/DisallowPartialRouteResource/DisallowPartialRouteFacadeResourceRule.php)

**Identifier:** `worksome.laravel.disallowPartialRouteResource`

This rule disallows the usage of the `Route::resource` method when combined with `only` or `except`. Instead, 
partial route resources should be split into multiple routes.

#### [`DisallowPartialRouteVariableResourceRule`](src/PHPStan/Laravel/DisallowPartialRouteResource/DisallowPartialRouteVariableResourceRule.php)

**Identifier:** `worksome.laravel.disallowPartialRouteResource`

Similar to `DisallowPartialRouteVariableResourceRule`, but prevents partial resource usage when used in a route group.

#### [`EnforceKebabCaseArtisanCommandsRule`](src/PHPStan/Laravel/EnforceKebabCaseArtisanCommandsRule.php)

**Identifier:** `worksome.laravel.kebabCaseArtisanCommands`

This rule will enforce the use of kebab-case for Artisan commands.

#### [`RequireWithoutTimestampsRule`](src/PHPStan/Laravel/Migrations/RequireWithoutTimestampsRule.php)

**Identifier:** `worksome.laravel.requireWithoutTimestamps`

This rule enforces that all `update`, `insert`, `save`, `saveQuietly`, `delete`, `restore`, method calls within Laravel migration files are properly enclosed in a `withoutTimestamps()` context.

## Custom PHP_CodeSniffer sniffs

The Worksome code style includes various custom PHP_CodeSniffer sniffs where auto-fixers via PHP CS Fixer are not possible.

### Generic

#### [Pascal-casing enum cases](src/Sniffs/Enums/PascalCasingEnumCasesSniff.php)

This ensures that all enum cases use pascal-casing (e.g. `Case::PascalCase`).

### Laravel

All custom sniffs specific to Laravel.

#### [Config filename kebab case](src/Sniffs/Laravel/ConfigFilenameKebabCaseSniff.php)

Checks if all config files are written in kebab case.

#### [Disallow `compact` usage](src/Sniffs/Functions/DisallowCompactUsageSniff.php)

Makes sure that `compact()` isn't used in code.

#### [Disallow `env` usage](src/Sniffs/Laravel/DisallowEnvUsageSniff.php)

Makes sure that you don't use `env` helper in your code, except for config files.

#### [Disallow `HasFactory` usage](src/Sniffs/Laravel/DisallowHasFactorySniff.php)

Ensures that the `HasFactory` trait is not used on models, this ensures that the factory class is called directly.

#### [Event listener suffix](src/Sniffs/Laravel/EventListenerSuffixSniff.php)

Enforces event listeners to end with a specific suffix, this suffix is defaulted to `Listener`.

| parameters | defaults   |
|------------|------------|
| suffix     | `Listener` |

#### [Disallow blade outside the `resources` directory](src/Sniffs/Laravel/DisallowBladeOutsideOfResourcesDirectorySniff.php)

Makes sure no `.blade.php` files exist outside of Laravel's `resources` directory.

| parameters         | defaults                   |
|--------------------|----------------------------|
| resourcesDirectory | `{YOUR_PROJECT}/resources` |

#### [Exception suffix](src/Sniffs/Classes/ExceptionSuffixSniff.php)

This ensures that all `Exception` classes should have a suffix of `Exception`.

### PhpDoc

All custom sniffs which are not specific to Laravel.

#### [Property dollar sign](src/Sniffs/PhpDoc/PropertyDollarSignSniff.php)

Makes sure that you always have a dollar sign in your properties defined in phpdoc.
```php
/**
* @property string $name
 */
class User {}
```

#### [Param tags with no type or comment](src/Sniffs/PhpDoc/DisallowParamNoTypeOrCommentSniff.php)

This removes all `@param` tags which has not specified a type or comment.

```php
/**
 * @param string $name
 * @param $type some random type
 * @param $other // <-- will be removed
 */
public function someMethod($name, $type, $other): void
{}
```

This is mainly because PHPStan requires this before it sees the property as valid.

#### [Disallow `TODO` comments](src/Sniffs/Comments/DisallowTodoCommentsSniff.php)

This ensures that all to-do comments are blocked from use. Jira should be used instead.

#### [Space in generics](src/PhpCsFixer/SpaceInGenericsFixer.php)

This ensures that generics types in PHPDoc comments contain a single space after the comma.

## Custom Rector rules

The Worksome code style includes custom Rector rules for automatically refactoring code.

### Generic

#### [Disallowed Attributes](src/Rector/Generic/DisallowedAttributesRector.php)

This ensures that specified [PHP attributes](https://www.php.net/manual/en/language.attributes.php) are automatically
removed when they are not allowed.

## Credits

- [Worksome](https://github.com/worksome)
- [Kuba Werłos](https://github.com/kubawerlos) for the initial code for [`SpaceInGenericsFixer`](./src/PhpCsFixer/SpaceInGenericsFixer.php)
- [All Contributors](../../contributors)
