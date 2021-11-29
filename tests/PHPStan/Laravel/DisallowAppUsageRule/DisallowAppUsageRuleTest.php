<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\DisallowAppUsageRule;

use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use RectorPrefix20210826\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;
use Worksome\CodingStyle\PHPStan\Laravel\DisallowAppHelperUsageRule;
use Worksome\CodingStyle\PHPStan\NamespaceBasedSuffixRule;

class DisallowAppUsageRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DisallowAppHelperUsageRule();
    }

    /**
     * @dataProvider provideData
     */
    public function testRule(string $path, array ...$errors): void
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
            'calls app helper with args' => [
                __DIR__ . '/Fixture/app_helper_with_arg.php.inc',
                [
                    'Usage of app helper is disallowed. Use dependency injection instead.',
                    7,
                ],
            ],
            'calls app helper without args' => [
                __DIR__ . '/Fixture/app_helper_without_arg.php.inc',
                [
                    'Usage of app helper is disallowed. Use dependency injection instead.',
                    7,
                ],
            ],
            'calls app function from other namespace' => [
                __DIR__ . '/Fixture/skip_app_function_in_namespace.php.inc',
            ]
        ];
    }
}