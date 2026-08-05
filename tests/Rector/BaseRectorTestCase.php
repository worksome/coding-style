<?php

namespace Worksome\CodingStyle\Tests\Rector;

use Pest\TestSuite;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

abstract class BaseRectorTestCase extends AbstractRectorTestCase
{
    public function provideConfigFilePath(): string
    {
        return dirname(TestSuite::getInstance()->getFilename()) . '/config/configured_rule.php';
    }
}
