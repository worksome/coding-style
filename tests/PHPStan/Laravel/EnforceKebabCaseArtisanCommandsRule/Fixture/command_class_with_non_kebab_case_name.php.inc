<?php

use Illuminate\Console\Command;

class TestCommandWithNonKebabCaseName extends Command
{
    protected $signature = 'blahBlah';

    public function handle()
    {
    }
}
