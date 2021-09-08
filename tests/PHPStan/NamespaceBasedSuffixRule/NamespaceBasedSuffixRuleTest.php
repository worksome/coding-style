<?php

namespace Worksome\CodingStyle\Tests\PHPStan\NamespaceBasedSuffixRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Worksome\CodingStyle\PHPStan\NamespaceBasedSuffixRule;

class NamespaceBasedSuffixRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NamespaceBasedSuffixRule([
            'App\\Events' => 'Event',
        ]);
    }

    public function testRule(): void
    {
        $this->analyse(
            [__DIR__ . '/fixture/fixture.php.inc'],
            [
                [
                    'Classes in namespace App\\Events should always be suffixed with Event.',
                    5,
                ],
            ]
        );
    }
}