<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture;

use Illuminate\Console\Command;

class TestCommandWithDescriptions extends Command
{
    protected $signature = 'blahBlah {Blah : Does something} {--Blah : Does something else}';

    public function handle()
    {
    }
}
