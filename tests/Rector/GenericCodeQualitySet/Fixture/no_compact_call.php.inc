<?php

namespace Worksome\CodingStyle\Tests\Rector\GenericCodeQualitySet\Fixture;

class NoCompactCall
{
    public function someMethod(): array
    {
        $var = 'test';

        return ['var' => $var];
    }
}

?>
