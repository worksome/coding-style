[![Latest Stable Version](https://poser.pugx.org/worksome/coding-style/v)](//packagist.org/packages/worksome/coding-style) [![Total Downloads](https://poser.pugx.org/worksome/coding-style/downloads)](//packagist.org/packages/worksome/coding-style) [![Latest Unstable Version](https://poser.pugx.org/worksome/coding-style/v/unstable)](//packagist.org/packages/worksome/coding-style) [![License](https://poser.pugx.org/worksome/coding-style/license)](//packagist.org/packages/worksome/coding-style)

# Worksomes Coding Style
This repository contains the coding style followed by Worksome.

It includes configuration for `phpcs`, `phpstan` and `rector`.

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
$ composer phpstan
$ composer rector-ci
```