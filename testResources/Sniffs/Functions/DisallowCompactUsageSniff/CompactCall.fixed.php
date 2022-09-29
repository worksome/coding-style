<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Functions\DisallowCompactUsageSniff;


class CompactCall
{
    public function someMethod(): array
    {
        $var = "test";
        $otherVar = "tester";

        return ['var' => $var, 'otherVar' => $otherVar];
    }
}