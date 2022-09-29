<?php

namespace Worksome\CodingStyle\Tests\PHPStan;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class BaseRuleTestCase extends RuleTestCase
{
    public Rule $rule;

    protected function getRule(): Rule
    {
        return $this->rule;
    }

    public static function getAdditionalConfigFiles(): array
    {
        return array_merge(parent::getAdditionalConfigFiles(), [
            __DIR__ . '/../../phpstan-rich-parser.neon',
        ]);
    }
}
