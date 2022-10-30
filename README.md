[![Latest Stable Version](https://poser.pugx.org/worksome/coding-style/v)](//packagist.org/packages/worksome/coding-style) [![Total Downloads](https://poser.pugx.org/worksome/coding-style/downloads)](//packagist.org/packages/worksome/coding-style) [![Latest Unstable Version](https://poser.pugx.org/worksome/coding-style/v/unstable)](//packagist.org/packages/worksome/coding-style) [![License](https://poser.pugx.org/worksome/coding-style/license)](//packagist.org/packages/worksome/coding-style)

# Worksomes Coding Style
This repository contains the coding style followed by Worksome.

It includes configuration for `ecs`,, `phpstan` and `rector`.

## Setup
Install this composer package

```
composer require worksome/coding-style --dev
```

Run the generate command for generating the config files.
```
composer generate-coding-style-stubs
```

Add the following section to your `composer.json` file
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

For using it simply run one of the scripts added to composer.
```
$ composer ecs
$ composer ecs:fix
$ composer phpstan
$ composer rector
$ composer rector:fix
```

## Custom PhpStan rules
This section will list all the custom phpstan rules this package adds.

### Generic
Rules that are applied to all projects.

#### DeclareStrictTypes
This rule is used to ensure that all PHP files include with the `declare(strict_types=1)` statement.

#### NamespaceBasedSuffix
Sets up configuration for suffixing the following namespaces

- `App\Events`: `Event`
- `App\Listener`: `Listener`
- `App\Policies`: `Policy`
- `App\Jobs`: `Job`

This makes sures events, listeners, policies and jobs has the same suffix.

### Laravel
Rules that are only applied in a Laravel context.

#### DisallowPartialRouteFacadeResource
This rule disallows the usage of the `Route::resource` method when combined with `only` or `except`. Instead, 
partial route resources should be split into multiple routes.

#### DisallowPartialRouteFacadeResource
Similar to `DisallowPartialRouteFacadeResource`, but prevents partial resource usage when used in a route group.

#### DisallowPHPUnit
This rule prevents PHPUnit tests in favour of Pest PHP. It will allow abstract `TestCase` classes.

#### EnforceKebabCaseArtisanCommandsRule
This rule will enforce the use of kebab-case for Artisan commands.


## Custom sniffs
List all the custom sniffs created by Worksome.

### Laravel
All custom sniffs specific to Laravel.

#### Config filename kebab case
Checks if all config files are written in kebab case.

#### Disallow env usage
Makes sure that you don't use `env` helper in your code, except for config files.

#### Event listener suffix
Enforces event listeners to end with a specific suffix, this suffix is defaulted to `Listener`.

| parameters | defaults |
| --- | ---  |
| suffix | Listener |

#### Disallow blade outside of the `resources` directory
Makes sure no `.blade.php` files exist outside of Laravel's `resources` directory.

| parameters | defaults |
| --- | ---  |
| resourcesDirectory | {YOUR_PROJECT}/resources |

### PhpDoc
All custom sniffs which are not specific to Laravel.

#### Property dollar sign
Makes sure that you always have a dollar sign in your properties defined in phpdoc.
```php
/**
* @property string $name
 */
class User {}
```

### Param tags with no type or comment
This removes all `@param` tags which has no specified a type or comment
```php
/**
 * @param string $name
 * @param $type some random type
 * @param $other // <-- will be removed
 */
public function someMethod($name, $type, $other): void
{}
```


This is mainly because phpstan requires this before it sees the property as valid.

## Credits

- [Worksome](https://github.com/worksome)
- [Kuba Werłos](https://github.com/kubawerlos) for the initial code for [`SpaceInGenericsFixer`](./src/PhpCsFixer/SpaceInGenericsFixer.php)
- [All Contributors](../../contributors)
