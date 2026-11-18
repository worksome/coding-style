<?php

namespace Worksome\CodingStyle\Tests\Rector\GenericCodeQualitySet\Fixture;

class CompactCall
{
    public function someMethod(): array
    {
        $var = 'test';
        $otherVar = 'tester';

        return compact('var', 'otherVar');
    }
}

?>
-----
<?php

namespace Worksome\CodingStyle\Tests\Rector\GenericCodeQualitySet\Fixture;

class CompactCall
{
    public function someMethod(): array
    {
        $var = 'test';
        $otherVar = 'tester';

        return ['var' => $var, 'otherVar' => $otherVar];
    }
}

?>
