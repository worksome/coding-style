<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule;

use TestCommandWithNonKebabCaseName;
use Worksome\CodingStyle\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule;
use Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture\TestCommandWithDescriptions;
use Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture\TestCommandWithMultilineSignature;
use Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture\TestCommandWithNonKebabCaseArgument;
use Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture\TestCommandWithNonKebabCaseArgumentAndOption;
use Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture\TestCommandWithNonKebabCaseNameArgumentAndOption;
use Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture\TestCommandWithNonKebabCaseOption;

it('checks kebab-case Artisan commands rule', function (string $path, array ...$errors) {
    $this->rule = new EnforceKebabCaseArtisanCommandsRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'valid command class' => [
        __DIR__ . '/Fixture/skip_valid_command_class.php.inc',
    ],
    'non-command class' => [
        __DIR__ . '/Fixture/skip_non_command_class.php.inc',
    ],
    'non-command class with signature property' => [
        __DIR__ . '/Fixture/skip_non_command_class_with_signature_property.php.inc',
    ],
    'command with non-kebab-case command name' => [
        __DIR__ . '/Fixture/command_class_with_non_kebab_case_name.php.inc',
        [
            'Command "' . TestCommandWithNonKebabCaseName::class . '" is not using kebab-case for the command name in its signature.',
            7,
        ],
    ],
    'command with non-kebab-case argument' => [
        __DIR__ . '/Fixture/command_class_with_non_kebab_case_argument.php.inc',
        [
            'Command "' . TestCommandWithNonKebabCaseArgument::class . '" is not using kebab-case for the "Blah" argument in its signature.',
            9,
        ],
    ],
    'command with non-kebab-case option' => [
        __DIR__ . '/Fixture/command_class_with_non_kebab_case_option.php.inc',
        [
            'Command "' . TestCommandWithNonKebabCaseOption::class . '" is not using kebab-case for the "Blah" option in its signature.',
            9,
        ],
    ],
    'command with non-kebab-case argument and option' => [
        __DIR__ . '/Fixture/command_class_with_non_kebab_case_argument_and_option.php.inc',
        [
            'Command "' . TestCommandWithNonKebabCaseArgumentAndOption::class . '" is not using kebab-case for the "Blah" argument in its signature.',
            9,
        ],
        [
            'Command "' . TestCommandWithNonKebabCaseArgumentAndOption::class . '" is not using kebab-case for the "Blah" option in its signature.',
            9,
        ],
    ],
    'command with non-kebab-case name, argument, and option' => [
        __DIR__ . '/Fixture/command_class_with_non_kebab_case_name_argument_and_option.php.inc',
        [
            'Command "' . TestCommandWithNonKebabCaseNameArgumentAndOption::class . '" is not using kebab-case for the command name in its signature.',
            9,
        ],
        [
            'Command "' . TestCommandWithNonKebabCaseNameArgumentAndOption::class . '" is not using kebab-case for the "Blah" argument in its signature.',
            9,
        ],
        [
            'Command "' . TestCommandWithNonKebabCaseNameArgumentAndOption::class . '" is not using kebab-case for the "Blah" option in its signature.',
            9,
        ],
    ],
    'command with multi-line signature' => [
        __DIR__ . '/Fixture/command_class_with_multi_line_signature.php.inc',
        [
            'Command "' . TestCommandWithMultilineSignature::class . '" is not using kebab-case for the command name in its signature.',
            9,
        ],
        [
            'Command "' . TestCommandWithMultilineSignature::class . '" is not using kebab-case for the "Blah" argument in its signature.',
            9,
        ],
        [
            'Command "' . TestCommandWithMultilineSignature::class . '" is not using kebab-case for the "Blah" option in its signature.',
            9,
        ],
    ],
    'command with descriptions for signature' => [
        __DIR__ . '/Fixture/command_class_with_descriptions_for_signature.php.inc',
        [
            'Command "' . TestCommandWithDescriptions::class . '" is not using kebab-case for the command name in its signature.',
            9,
        ],
        [
            'Command "' . TestCommandWithDescriptions::class . '" is not using kebab-case for the "Blah" argument in its signature.',
            9,
        ],
        [
            'Command "' . TestCommandWithDescriptions::class . '" is not using kebab-case for the "Blah" option in its signature.',
            9,
        ],
    ],
]);
