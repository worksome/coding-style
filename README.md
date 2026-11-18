# Worksome Coding Style

[![Latest Stable Version](https://img.shields.io/packagist/v/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)
[![Total Downloads](https://img.shields.io/packagist/dt/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)
[![Latest Unstable Version](https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square)](https://packagist.org/packages/worksome/coding-style#dev-main)
[![License](https://img.shields.io/packagist/l/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)

This repository contains the coding style followed by Worksome.

It includes configuration for [ECS](https://github.com/ecsphp/ecs), [PHPStan](https://phpstan.org), and [Rector](https://getrector.org).

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

### PHPStan

PHPStan extensions are registered via [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer), which is installed
alongside this package. Allow the plugin when prompted by Composer, or add it to your `composer.json` file:

```json
"config": {
    "allow-plugins": {
        "phpstan/extension-installer": true
    }
}
```

The Worksome rules, along with the PHPStan extensions this package depends on, are then loaded automatically.

Laravel projects should also install Larastan and the Larastan strict rules:

```
composer require --dev larastan/larastan canvural/larastan-strict-rules
```

The Laravel rules (and Larastan within the Rector config) are only loaded when Larastan is installed, and the strict
rules are only loaded when both packages are installed. Packages listed in the extension installer's `ignore` option
are treated as not installed.

> **Note:** Do not include the configuration files of any PHPStan extension that is registered with the extension installer (e.g. `vendor/larastan/larastan/extension.neon`
> or `vendor/worksome/coding-style/larastan.neon`) in your `phpstan.neon` file. PHPStan will fail if a file is included more than once.

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
- [`UnaryOperatorSpacesFixer`](https://cs.symfony.com/doc/rules/operator/unary_operator_spaces.html)

#### [PHP CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer)

- [`CommentedOutCodeSniff` ⚙️](https://github.com/PHPCSStandards/PHP_CodeSniffer/wiki/Customisable-Sniff-Properties#squizphpcommentedoutcode)
- [`ForbiddenFunctionsSniff` ⚙️](https://github.com/PHPCSStandards/PHP_CodeSniffer/wiki/Customisable-Sniff-Properties#genericphpforbiddenfunctions)
- [`SpaceAfterNotSniff`](https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/Formatting/SpaceAfterNotSniff.php)
- [`MethodDeclarationSniff`](https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/src/Standards/PSR2/Sniffs/Methods/MethodDeclarationSniff.php)
- [`SpaceAfterCastSniff`](https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/Formatting/SpaceAfterCastSniff.php)

#### [Slevomat Coding Standard](https://github.com/slevomat/coding-standard)

- [`DisallowGroupUseSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/namespaces.md#slevomatcodingstandardnamespacesdisallowgroupuse)
- [`ForbiddenAnnotationsSniff` ⚙️](https://github.com/slevomat/coding-standard/blob/master/doc/commenting.md#slevomatcodingstandardcommentingforbiddenannotations-)
- [`ModernClassNameReferenceSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassesmodernclassnamereference-)
- [`NamespaceDeclarationSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/namespaces.md#slevomatcodingstandardnamespacesnamespacedeclaration-)
- [`ParameterTypeHintSpacingSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/type-hints.md#slevomatcodingstandardtypehintsparametertypehintspacing-)
- [`PropertyDeclarationSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassespropertydeclaration-)
- [`RequireMultiLineCallSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/functions.md#slevomatcodingstandardfunctionsrequiremultilinecall-)
- [`RequireMultiLineConditionSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/control-structures.md#slevomatcodingstandardcontrolstructuresrequiremultilinecondition-)
- [`RequireMultiLineMethodSignatureSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/classes.md#slevomatcodingstandardclassesrequiremultilinemethodsignature-)
- [`RequireMultiLineTernaryOperatorSniff` ⚙️](https://github.com/slevomat/coding-standard/blob/master/doc/control-structures.md#slevomatcodingstandardcontrolstructuresrequiremultilineternaryoperator-)
- [`RequireOneNamespaceInFileSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/namespaces.md#slevomatcodingstandardnamespacesrequireonenamespaceinfile)
- [`RequireShortTernaryOperatorSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/control-structures.md#slevomatcodingstandardcontrolstructuresrequireshortternaryoperator-)
- [`RequireTrailingCommaInDeclarationSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/functions.md#slevomatcodingstandardfunctionsrequiretrailingcommaindeclaration-)
- [`UselessConstantTypeHintSniff`](https://github.com/slevomat/coding-standard/blob/master/doc/type-hints.md#slevomatcodingstandardtypehintsuselessconstanttypehint-)

#### [Symplify Coding Standard](https://github.com/symplify/coding-standard)

- [`LineLengthFixer` ⚙️](https://github.com/symplify/coding-standard/blob/main/docs/rules_overview.md#linelengthfixer)

#### [Worksome](src)

- [`DisallowParamNoTypeOrCommentFixer`](#param-tags-with-no-type-or-comment)
- [`PropertyDollarSignFixer`](#property-dollar-sign)
- [`SpaceInGenericsFixer`](#space-in-generics)

## Custom PHPStan rules

The Worksome code style includes the following custom PHPStan rules.

### Generic

Rules that are applied to all projects.

#### [`DeclareStrictTypes`](src/PHPStan/DeclareStrictTypesRule.php)

**Identifier:** `worksome.declareStrictTypes`

This rule is used to ensure that all PHP files include with the `declare(strict_types=1)` statement.

#### [`DisallowTodoComments`](src/PHPStan/DisallowTodoCommentsRule.php)

**Identifier:** `worksome.disallowTodoComments`

This rule prevents to-do comments from being used. Jira should be used instead.

#### [`DisallowPHPUnit`](src/PHPStan/DisallowPHPUnitRule.php)

**Identifier:** `worksome.disallowPhpunit`

This rule prevents PHPUnit tests in favour of Pest PHP. It will allow abstract `TestCase` classes.

#### [`ExceptionSuffix`](src/PHPStan/ExceptionSuffixRule.php)

**Identifier:** `worksome.exceptionSuffix`

This rule ensures that all classes implementing `Throwable` have an `Exception` suffix.

#### [`NamespaceBasedSuffix`](src/PHPStan/NamespaceBasedSuffixRule.php)

**Identifier:** `worksome.namespaceBasedSuffix`

Sets up configuration for suffixing the following namespaces

- `App\Events`: `Event`
- `App\Listeners`: `Listener`
- `App\Policies`: `Policy`
- `App\Jobs`: `Job`

This makes sures events, listeners, policies and jobs has the same suffix.

#### [`PascalCaseEnumCases`](src/PHPStan/PascalCaseEnumCasesRule.php)

**Identifier:** `worksome.pascalCaseEnumCases`

This rule ensures that all enum cases use pascal-casing (e.g. `Case::PascalCase`).

### Laravel

Rules that are only applied in a Laravel context.

#### [`ConfigFilenameKebabCaseRule`](src/PHPStan/Laravel/ConfigFilenameKebabCaseRule.php)

**Identifier:** `worksome.laravel.configFilenameKebabCase`

This rule ensures that all config files are named in kebab-case. It only applies when the `config` directory is included in your PHPStan paths.

#### [`DisallowBladeOutsideOfResourcesDirectoryRule`](src/PHPStan/Laravel/DisallowBladeOutsideOfResourcesDirectoryRule.php)

**Identifier:** `worksome.laravel.disallowBladeOutsideOfResourcesDirectory`

This rule ensures that no `.blade.php` files are placed outside of Laravel's `resources` directory. The directory can be changed with the `bladeResourcesDirectory` parameter (defaults to `%currentWorkingDirectory%/resources`).

#### [`DisallowEnvironmentCheckRule`](src/PHPStan/Laravel/DisallowEnvironmentCheck/DisallowEnvironmentCheckRule.php)

**Identifier:** `worksome.laravel.disallowEnvironmentCheck`

This rule will prevent checking the application environment, instead preferring that a driver based approach is used.

#### [`EnforceKebabCaseArtisanCommandsRule`](src/PHPStan/Laravel/EnforceKebabCaseArtisanCommandsRule.php)

**Identifier:** `worksome.laravel.kebabCaseArtisanCommands`

This rule will enforce the use of kebab-case for Artisan commands.

#### [`RequireWithoutTimestampsRule`](src/PHPStan/Laravel/Migrations/RequireWithoutTimestampsRule.php)

**Identifier:** `worksome.laravel.requireWithoutTimestamps`

This rule enforces that all `update`, `insert`, `save`, `saveQuietly`, `delete`, `restore`, method calls within Laravel migration files are properly enclosed in a `withoutTimestamps()` context.

#### Third-party rules

The following are enabled through configuration of third-party rules:

- **Disallow `env` usage** — Larastan's `noEnvCallsOutsideOfConfig` rule (identifier `larastan.noEnvCallsOutsideOfConfig`) ensures `env()` is only called in config files.
- **Disallow `HasFactory` usage** — [`disallowedClasses`](https://github.com/spaze/phpstan-disallowed-calls) ensures the `HasFactory` trait is not used, so that factory classes are called directly.

## Custom PHP CS Fixer fixers

The Worksome code style includes the following custom PHP CS Fixer fixers, which are applied via ECS.

#### [Property dollar sign](src/PhpCsFixer/PropertyDollarSignFixer.php)

Makes sure that you always have a dollar sign in your properties defined in phpdoc.

```php
/**
 * @property string $name
 */
class User {}
```

#### [Param tags with no type or comment](src/PhpCsFixer/DisallowParamNoTypeOrCommentFixer.php)

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

#### [Space in generics](src/PhpCsFixer/SpaceInGenericsFixer.php)

This ensures that generics types in PHPDoc comments contain a single space after the comma.

## Custom Rector rules

The Worksome code style includes custom Rector rules for automatically refactoring code.

### Generic

#### [Disallowed Attributes](src/Rector/Generic/DisallowedAttributesRector.php)

This ensures that specified [PHP attributes](https://www.php.net/manual/en/language.attributes.php) are automatically
removed when they are not allowed.

#### [`CompactToVariablesRector`](https://getrector.com/rule-detail/compact-to-variables-rector)

Replaces `compact()` calls with an explicit array, as part of the generic code quality set.

## Credits

- [Worksome](https://github.com/worksome)
- [Kuba Werłos](https://github.com/kubawerlos) for the initial code for [`SpaceInGenericsFixer`](./src/PhpCsFixer/SpaceInGenericsFixer.php)
- [All Contributors](../../contributors)
