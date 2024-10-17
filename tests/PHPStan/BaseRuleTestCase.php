<?php

namespace Worksome\CodingStyle\Tests\PHPStan;

use Larastan\Larastan\ApplicationResolver;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class BaseRuleTestCase extends RuleTestCase
{
    public Rule $rule;

    protected function setUp(): void
    {
        parent::setUp();

        if (! defined('LARAVEL_VERSION') && class_exists(ApplicationResolver::class)) {
            define('LARAVEL_VERSION', ApplicationResolver::resolve()->version());
        }
    }

    protected function getRule(): Rule
    {
        return $this->rule;
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            ... parent::getAdditionalConfigFiles(),
            __DIR__ . '/../../phpstan-rich-parser.neon',
            __DIR__ . '/../../vendor/larastan/larastan/extension.neon',
        ];
    }
}
