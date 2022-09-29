<?php

namespace Worksome\CodingStyle;

use Composer\Plugin\Capability\CommandProvider;

class CodingStyleCommandProvider implements CommandProvider
{
    public function getCommands(): array
    {
        return [
            new GenerateCommand(),
        ];
    }
}
