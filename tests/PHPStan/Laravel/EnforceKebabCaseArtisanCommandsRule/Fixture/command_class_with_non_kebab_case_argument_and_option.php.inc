<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture;

use Illuminate\Console\Command;

class TestCommandWithNonKebabCaseArgumentAndOption extends Command
{
    protected $signature = 'blah {Blah} {--Blah}';

    public function handle()
    {
    }
}
