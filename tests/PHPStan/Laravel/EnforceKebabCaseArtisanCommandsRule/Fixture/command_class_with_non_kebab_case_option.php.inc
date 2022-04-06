<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture;

use Illuminate\Console\Command;

class TestCommandWithNonKebabCaseOption extends Command
{
    protected $signature = 'blah {--Blah}';

    public function handle()
    {
    }
}
