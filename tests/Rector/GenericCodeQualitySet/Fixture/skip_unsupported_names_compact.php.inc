<?php

namespace Worksome\CodingStyle\Tests\Rector\GenericCodeQualitySet\Fixture;

class SkipUnsupportedNamesCompact
{
    public function someMethod(): array
    {
        $a = 1;

        return [compact('a', 'my name'), compact('a', ''), compact('a', '1x'), compact('a', '_SERVER'), compact('this')];
    }
}

?>
