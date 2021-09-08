<?php

namespace Worksome\CodingStyle\Tests\PHPStan\NamespaceBasedSuffixRule;

use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use RectorPrefix20210826\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;
use Worksome\CodingStyle\PHPStan\NamespaceBasedSuffixRule;

class NamespaceBasedSuffixRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NamespaceBasedSuffixRule([
            'App\\Events' => 'Event',
        ]);
    }

    /**
     * @dataProvider provideData
     */
    public function testRule(string $path, array $errors): void
    {
        $this->analyse(
            [
                $path
            ],
            $errors,
        );
    }

    public function provideData(): array
    {
        return [
            'has namespace' => [
                __DIR__ . '/Fixture/fixture.php.inc',
                [
                    [
                        'Classes in namespace App\\Events should always be suffixed with Event.',
                        5,
                    ],
                ],
            ],
            'has other namespace' => [
                __DIR__ . '/Fixture/skip_non_event_namespace.php.inc',
                [],
            ],
            'has namespace and suffix' => [
                __DIR__ . '/Fixture/skip_suffix_event.php.inc',
                [],
            ],
            'has namespace, but is anonymous class' => [
                __DIR__ . '/Fixture/skip_annonymous_class_in_namespace.php.inc',
                [],
            ]
        ];
    }
}