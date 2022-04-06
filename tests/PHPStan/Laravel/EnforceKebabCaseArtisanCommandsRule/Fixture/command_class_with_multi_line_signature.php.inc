<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture;

use Illuminate\Console\Command;

class TestCommandWithMultilineSignature extends Command
{
    protected $signature = 'blahBlah
                            {Blah}
                            {--Blah}';

    public function handle()
    {
    }
}
