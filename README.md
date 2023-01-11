[![Latest Stable Version](https://img.shields.io/packagist/v/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)
[![Total Downloads](https://img.shields.io/packagist/dt/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)
[![Latest Unstable Version](https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square)](https://packagist.org/packages/worksome/coding-style#dev-main)
[![License](https://img.shields.io/packagist/l/worksome/coding-style?style=flat-square)](https://packagist.org/packages/worksome/coding-style)

# Worksomes Coding Style

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

## Custom PHPStan rules

This section will list all the custom PHPStan rules this package adds.

### Generic

Rules that are applied to all projects.

#### [`DeclareStrictTypes`](src/PHPStan/DeclareStrictTypesRule.php)

This rule is used to ensure that all PHP files include with the `declare(strict_types=1)` statement.

#### [`DisallowPHPUnit`](src/PHPStan/DisallowPHPUnitRule.php)

This rule prevents PHPUnit tests in favour of Pest PHP. It will allow abstract `TestCase` classes.

#### [`NamespaceBasedSuffix`](src/PHPStan/NamespaceBasedSuffixRule.php)

Sets up configuration for suffixing the following namespaces

- `App\Events`: `Event`
- `App\Listener`: `Listener`
- `App\Policies`: `Policy`
- `App\Jobs`: `Job`

This makes sures events, listeners, policies and jobs has the same suffix.

### Laravel

Rules that are only applied in a Laravel context.

#### [`DisallowPartialRouteFacadeResource`](src/PHPStan/Laravel/DisallowPartialRouteResource/DisallowPartialRouteFacadeResourceRule.php)

This rule disallows the usage of the `Route::resource` method when combined with `only` or `except`. Instead, 
partial route resources should be split into multiple routes.

#### [`DisallowPartialRouteVariableResourceRule`](src/PHPStan/Laravel/DisallowPartialRouteResource/DisallowPartialRouteVariableResourceRule.php)

Similar to `DisallowPartialRouteVariableResourceRule`, but prevents partial resource usage when used in a route group.

#### [`EnforceKebabCaseArtisanCommandsRule`](src/PHPStan/Laravel/EnforceKebabCaseArtisanCommandsRule.php)

This rule will enforce the use of kebab-case for Artisan commands.

#### [`DisallowEnvironmentCheckRule`](src/PHPStan/Laravel/DisallowEnvironmentCheck/DisallowEnvironmentCheckRule.php)

This rule will prevent checking the application environment, instead preferring that a driver based approach is used.

## Custom sniffs

List all the custom sniffs created by Worksome.

### Laravel

All custom sniffs specific to Laravel.

#### [Config filename kebab case](src/Sniffs/Laravel/ConfigFilenameKebabCaseSniff.php)

Checks if all config files are written in kebab case.

#### [Disallow env usage](src/Sniffs/Laravel/DisallowEnvUsageSniff.php)

Makes sure that you don't use `env` helper in your code, except for config files.

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

### [Param tags with no type or comment](src/Sniffs/PhpDoc/DisallowParamNoTypeOrCommentSniff.php)

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

## Credits

- [Worksome](https://github.com/worksome)
- [Kuba Werłos](https://github.com/kubawerlos) for the initial code for [`SpaceInGenericsFixer`](./src/PhpCsFixer/SpaceInGenericsFixer.php)
- [All Contributors](../../contributors)
