<?php

namespace Worksome\CodingStyle\Tests\Rector;

use Illuminate\Support\Str;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

/**
 * @property-read string $__filename
 */
abstract class BaseRectorTestCase extends AbstractRectorTestCase
{
    public function provideConfigFilePath(): string
    {
        return Str::beforeLast(invade($this)->__filename, '/') . '/config/configured_rule.php';
    }
}
