[![Latest Stable Version](https://poser.pugx.org/worksome/coding-style/v)](//packagist.org/packages/worksome/coding-style) [![Total Downloads](https://poser.pugx.org/worksome/coding-style/downloads)](//packagist.org/packages/worksome/coding-style) [![Latest Unstable Version](https://poser.pugx.org/worksome/coding-style/v/unstable)](//packagist.org/packages/worksome/coding-style) [![License](https://poser.pugx.org/worksome/coding-style/license)](//packagist.org/packages/worksome/coding-style)

# Worksomes Coding Style
This repository contains the coding style followed by Worksome.

It includes configuration for `php-cs-fixer`, `phpcs`, `phpstan` and `rector`.

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
    "phpcs": "vendor/bin/phpcs",
    "php-cs-fixer": "vendor/bin/php-cs-fixer fix --ansi",
    "php-cs-fixer-ci": "vendor/bin/php-cs-fixer fix --dry-run --ansi",
    "phpcbf": "vendor/bin/phpcbf",
    "phpstan": "vendor/bin/phpstan analyse",
    "rector-ci": "vendor/bin/rector process --dry-run --ansi",
    "rector": "vendor/bin/rector process --ansi"
},
```

## Usage

For using it simply run one of the scripts added to composer.
```
$ composer phpcs
$ composer php-cs-fixer
$ composer phpstan
$ composer rector-ci
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

#### DisallowAppHelperUsage
This rule disallows the usage of laravel's `app` helper function in favour of using dependency injection instead.

#### DisallowPartialRouteFacadeResource
This rule disallows the usage of the `Route::resource` method when combined with `only` or `except`. Instead, 
partial route resources should be split into multiple routes.

#### DisallowPartialRouteFacadeResource
Similar to `DisallowPartialRouteFacadeResource`, but prevents partial resource usage when used in a route group.

#### DisallowPHPUnit
This rule prevents PHPUnit tests in favour of Pest PHP. It will allow abstract `TestCase` classes.

#### EnforceKebabCaseArtisanCommandsRule
This rule will enforce the use of kebab-case for Artisan commands.

## Credits

- [Worksome](https://github.com/worksome)
- [Kuba Werłos](https://github.com/kubawerlos) for the initial code for [`SpaceInGenericsFixer`](./src/PhpCsFixer/SpaceInGenericsFixer.php)
- [All Contributors](../../contributors)
