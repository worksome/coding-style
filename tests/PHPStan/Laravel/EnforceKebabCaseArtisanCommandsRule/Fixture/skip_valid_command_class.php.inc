<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\EnforceKebabCaseArtisanCommandsRule\Fixture;

use Illuminate\Console\Command;

class ValidTestCommand extends Command
{
    protected $signature = 'blah';

    public function handle()
    {
    }
}
